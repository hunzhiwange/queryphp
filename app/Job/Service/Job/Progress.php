<?php

declare(strict_types=1);

namespace App\Job\Service\Job;

use App\Job\Entity\Job;
use App\Job\Entity\JobContent;
use App\Job\Entity\JobProcessEnum;
use App\Job\Entity\JobTypeEnum;
use App\Job\Service\JobParams;

class Progress
{
    public function handle(ProgressParams $params): array
    {
        $job = $this->checkJob($params);
        $content = $this->getJobContent($params);
        $this->runJob($job, $content);

        return [];
    }

    public function updateJobNumber(int $jobId, int $success = 0, int $fail = 0): void
    {
        if ($success) {
            Job::select()
                ->where('id', $jobId)
                ->updateIncrease('success', $success)
            ;
        }

        if ($fail) {
            Job::select()
                ->where('id', $jobId)
                ->updateIncrease('fail', $fail)
            ;
        }
    }

    public function updateJobProcess(int $jobId): void
    {
        $job = Job::findOrFail($jobId, ['id', 'fail']);
        $process = $job->fail ?
            JobProcessEnum::PROCESSING_FAILED->value :
            JobProcessEnum::PROCESSED_SUCCESSFULLY->value;
        Job::select()
            ->where('id', $jobId)
            ->update(['process' => $process])
        ;
    }

    private function getJobContent(ProgressParams $params): array
    {
        $jobContent = JobContent::findOrFail(function ($select) use ($params): void {
            $select->where('job_id', $params->id);
        }, ['content']);

        $content = json_decode((string) $jobContent->content, true, 512, JSON_THROW_ON_ERROR);
        if (!\is_array($content)) {
            throw new \Exception('Job content is not array');
        }
        if (\count($content) < 2) {
            throw new \Exception('Job content is empty');
        }

        return \array_slice($content, 2);
    }

    private function runJob(Job $job, array $content): array
    {
        [$jobServiceClass, $jobServiceParamsClass] = $this->parseJobService($job);

        $jobService = new $jobServiceClass();
        if (!\is_callable([$jobService, 'handle'])) {
            throw new \Exception(sprintf('Job service %s is not callable.', $jobServiceClass));
        }

        $jobServiceParams = new $jobServiceParamsClass([
            'progress' => $this,
            'job_id' => $job->id,
            'job_content' => $content,
        ]);

        return $jobService->handle($jobServiceParams);
    }

    private function checkJob(ProgressParams $params): Job
    {
        $job = Job::findOrFail($params->id, ['id', 'process', 'type']);
        if ($job->process !== JobProcessEnum::PENDING->value) {
            throw new \Exception('Job is not pending');
        }

        return $job;
    }

    private function parseJobService(Job $job): array
    {
        $jobType = JobTypeEnum::from($job->type);
        $jobTypeName = strtolower($jobType->name);
        $jobTypeName = str_replace('_', ':', $jobTypeName);
        $jobTypeName = str_replace(':dash:', '_', $jobTypeName);

        $app = 'base';
        if (str_contains($jobTypeName, ':')) {
            // 第一步解析出应用
            $colonPos = (int) strpos($jobTypeName, ':');
            $app = substr($jobTypeName, 0, $colonPos);
            $jobTypeName = substr($jobTypeName, $colonPos + 1);

            // 剩余的路径为目录，暂时不支持
            // @todo 移除目录的设计
            if (str_contains($jobTypeName, ':')) {
                $jobTypeName = implode('\\', array_map(fn ($v) => ucfirst($v), explode(':', $jobTypeName)));
            }
        }

        if (str_contains($jobTypeName, '_')) {
            $jobTypeName = implode('', array_map(fn ($v) => ucfirst($v), explode('_', $jobTypeName)));
        }

        $app = ucfirst($app);
        $jobServiceClass = "App\\{$app}\\Service\\".ucfirst($jobTypeName);
        if (!class_exists($jobServiceClass)) {
            throw new \Exception(sprintf('Job service %s is not exists.', $jobServiceClass));
        }

        $jobServiceParamsClass = $jobServiceClass.'Params';
        if (class_exists($jobServiceParamsClass)) {
            if (!is_subclass_of($jobServiceParamsClass, JobParams::class)) {
                throw new \Exception(sprintf('Job service params %s must be subclass of %s.', $jobServiceParamsClass, JobParams::class));
            }
        } else {
            $jobServiceParamsClass = JobParams::class;
        }

        return [$jobServiceClass, $jobServiceParamsClass];
    }
}
