<?php

declare(strict_types=1);

namespace Hizpark\DirectoryTreeViewer\Tests;

use Hizpark\DirectoryTreeViewer\DirectoryTreeViewer;
use PHPUnit\Framework\TestCase;

class DirectoryTreeViewerTest extends TestCase
{
    private string $testDir;

    protected function setUp(): void
    {
        // 创建临时测试目录结构
        $this->testDir = sys_get_temp_dir() . '/tree_viewer_test';

        mkdir($this->testDir . '/sub_dir1', 0o777, true);
        mkdir($this->testDir . '/sub_dir2');

        file_put_contents($this->testDir . '/file1.txt', 'File 1');
        file_put_contents($this->testDir . '/sub_dir1/file2.txt', 'File 2');
        file_put_contents($this->testDir . '/sub_dir2/file3.txt', 'File 3');
    }

    protected function tearDown(): void
    {
        // 清理测试目录
        $this->deleteDirectory($this->testDir);
    }

    private function deleteDirectory(string $dir): void
    {
        if (!file_exists($dir)) {
            return;
        }

        foreach (scandir($dir) as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path = $dir . DIRECTORY_SEPARATOR . $item;

            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }

        rmdir($dir);
    }

    public function testRenderOutputsExpectedTree(): void
    {
        $viewer = new DirectoryTreeViewer();
        $output = $viewer->render($this->testDir);

        // 简单断言输出包含某些关键元素
        $this->assertStringContainsString('📂 ' . basename($this->testDir), $output);
        $this->assertStringContainsString('📂 sub_dir1', $output);
        $this->assertStringContainsString('📂 sub_dir2', $output);
        $this->assertStringContainsString('📄 file1.txt', $output);
        $this->assertStringContainsString('📄 file2.txt', $output);
        $this->assertStringContainsString('📄 file3.txt', $output);
    }
}
