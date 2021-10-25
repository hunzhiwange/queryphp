<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use App\Domain\Entity\Project\ProjectIssue;
use App\Domain\Entity\Project\ProjectIssueModule;
use App\Domain\Entity\Project\ProjectIssueRelease;
use App\Domain\Entity\Project\ProjectIssueTag;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use App\Domain\Validate\Validate;
use Egulias\EmailValidator\Exception\CommaInDomain;
use Leevel\Database\Ddd\Select;
use Leevel\Validate\UniqueRule;

//use App\Domain\Validate\Project\ProjectModule as ProjectProjectModule;

/**
 * 项目任务更新.
 */
class Update
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(UpdateParams $params): array
    {
        //$this->validateArgs($params);
        if (isset($params->tags)) {
            $this->tags($params);
        }

        if (isset($params->releases)) {
            $this->releases($params);
        }

        if (isset($params->modules)) {
            $this->modules($params);
        }

        if (isset($params->completed) && 
            ProjectIssue::COMPLETED_TRUE === $params->completed &&
            !isset($params->completedDate)) {
            $params->completedDate = \get_current_date();
        }

        return $this->save($params)->toArray();
    }

    private function tags(UpdateParams $params)
    {
        $this->w->persist(function() use($params) {
            $old =  $this->w
                ->repository(ProjectIssueTag::class)
                ->findAll(function (Select $select) use ($params) {
                    $select->where('project_issue_id', $params->id);
                });
            $oldid = array_column($old->toArray(), 'id', 'project_tag_id');
            $old = array_column($old->toArray(), 'project_tag_id');
            $now = $params->tags->toArray();
            $del = array_diff($old, $now);
            $updateData = [];
            foreach ($params->tags as $projectTagId) {
                if (in_array($projectTagId, $old)) {
                    $updateData[] = [
                        'id' => $oldid[$projectTagId],
                        'project_issue_id' => $params->id,
                        'project_tag_id' => $projectTagId,
                        'delete_at' => 0,
                    ];
                } else {
                    $updateData[] = [
                        'id' => 0,
                        'project_issue_id' => $params->id,
                        'project_tag_id' => $projectTagId,
                        'delete_at' => 0,
                    ];
                }
            }
            foreach ($del as $id) {
                $updateData[] = [
                    'id' => $oldid[$id],
                    'project_issue_id' => $params->id,
                    'project_tag_id' => $id,
                    'delete_at' => time(),
                ];
            }
            \inject_company($updateData);
            ProjectIssueTag::repository()->insertAll($updateData, replace:['delete_at']);
        });
    }

    private function releases(UpdateParams $params)
    {
        $this->w->persist(function() use($params) {
            $old =  $this->w
                ->repository(ProjectIssueRelease::class)
                ->findAll(function (Select $select) use ($params) {
                    $select->where('project_issue_id', $params->id);
                });
            $oldid = array_column($old->toArray(), 'id', 'project_release_id');
            $old = array_column($old->toArray(), 'project_release_id');
            $now = $params->releases->toArray();
            $del = array_diff($old, $now);
            $updateData = [];
            foreach ($params->releases as $projectReleaseId) {
                if (in_array($projectReleaseId, $old)) {
                    $updateData[] = [
                        'id' => $oldid[$projectReleaseId],
                        'project_issue_id' => $params->id,
                        'project_release_id' => $projectReleaseId,
                        'delete_at' => 0,
                    ];
                } else {
                    $updateData[] = [
                        'id' => 0,
                        'project_issue_id' => $params->id,
                        'project_release_id' => $projectReleaseId,
                        'delete_at' => 0,
                    ];
                }
            }
            foreach ($del as $id) {
                $updateData[] = [
                    'id' => $oldid[$id],
                    'project_issue_id' => $params->id,
                    'project_release_id' => $id,
                    'delete_at' => time(),
                ];
            }
            \inject_company($updateData);
            ProjectIssueRelease::repository()->insertAll($updateData, replace:['delete_at']);
        });
    }

    private function modules(UpdateParams $params)
    {
        $this->w->persist(function() use($params) {
            $old =  $this->w
                ->repository(ProjectIssueModule::class)
                ->findAll(function (Select $select) use ($params) {
                    $select->where('project_issue_id', $params->id);
                });
            $oldid = array_column($old->toArray(), 'id', 'project_module_id');
            $old = array_column($old->toArray(), 'project_module_id');
            $now = $params->modules->toArray();
            $del = array_diff($old, $now);
            $updateData = [];
            foreach ($params->modules as $projectModuleId) {
                if (in_array($projectModuleId, $old)) {
                    $updateData[] = [
                        'id' => $oldid[$projectModuleId],
                        'project_issue_id' => $params->id,
                        'project_module_id' => $projectModuleId,
                        'delete_at' => 0,
                    ];
                } else {
                    $updateData[] = [
                        'id' => 0,
                        'project_issue_id' => $params->id,
                        'project_module_id' => $projectModuleId,
                        'delete_at' => 0,
                    ];
                }
            }
            foreach ($del as $id) {
                $updateData[] = [
                    'id' => $oldid[$id],
                    'project_issue_id' => $params->id,
                    'project_module_id' => $id,
                    'delete_at' => time(),
                ];
            }
            \inject_company($updateData);
            ProjectIssueModule::repository()->insertAll($updateData, replace:['delete_at']);
        });
    }

    /**
     * 保存.
     */
    private function save(UpdateParams $params): ProjectIssue
    {
        $this->w
            ->persist($entity = $this->entity($params))
            ->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 验证参数.
     */
    private function entity(UpdateParams $params): ProjectIssue
    {
        $entity = $this->find($params->id);
        $entity->withProps($this->data($params));

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): ProjectIssue
    {
        return $this->w
            ->repository(ProjectIssue::class)
            ->findOrFail($id);
    }

    /**
     * 组装实体数据.
     */
    private function data(UpdateParams $params): array
    {
        return $params
            ->except([
                'id',
                'tags',
                'releases',
                'modules',
            ])
            ->withoutNull()
            ->toArray();
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\ProjectBusinessException
     */
    private function validateArgs(UpdateParams $params): void
    {
        $uniqueRule = UniqueRule::rule(
            ProjectModule::class,
            exceptId:$params->id,
            additional:[]
        );

        $validator = Validate::make(new ProjectProjectModule($uniqueRule), 'update', $params->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_MODULE_UPDATE_INVALID_ARGUMENT, $e, true);
        }
    }
}
