<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

final class Test extends AbstractSeed
{
    use SeedBase;

    public function run(): void
    {
        if (getenv('RUNTIME_SEED_CLEAR')) {
            $this->clear();

            return;
        }

        $this->seed();
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
INSERT INTO `test`(`id`, `platform_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7564752184283136, 100000, 'foo', '2019-08-25 21:19:23', '2023-03-26 13:15:55', 0, 0, 0, 0);
INSERT INTO `test`(`id`, `platform_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7564752201060352, 100000, 'bar', '2019-08-25 21:19:23', '2023-03-26 13:15:52', 0, 0, 0, 0);
EOT;

        $this->execute($sql);
    }

    private function clear(): void
    {
        $sql = <<<'EOT'
TRUNCATE `test`;
EOT;

        $this->execute($sql);
    }
}
