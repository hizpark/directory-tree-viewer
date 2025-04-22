<?php

declare(strict_types=1);

namespace Hizpark\DirectoryTreeViewer;

use RuntimeException;

/**
 * DirectoryStructureRenderer 类用于渲染指定目录的树状结构
 * 它可以递归地打印目录及其文件，并且为每一层提供适当的缩进
 */
class DirectoryTreeViewer
{
    /**
     * 渲染指定目录的结构，包括根目录及其下的所有子目录和文件
     *
     * @param string $directory 目标目录的路径
     *
     * @throws RuntimeException 如果目录不存在或不是有效的目录
     *
     * @return string 返回目录结构的字符串表示，包括根目录、子目录和文件
     */
    public function render(string $directory): string
    {
        $directory = realpath($directory);

        if (!$directory) {
            throw new RuntimeException("❌ 路径異常: $directory");
        }

        // 检查目录是否存在
        if (!file_exists($directory)) {
            throw new RuntimeException("❌ 路径不存在: $directory");
        }

        // 检查是否为有效目录
        if (!is_dir($directory)) {
            throw new RuntimeException("❌ 不是有效的目录: $directory");
        }

        $files        = scandir($directory);
        $directories  = [];
        $regularFiles = [];

        // 分类文件与目录
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            if (is_dir($directory . DIRECTORY_SEPARATOR . $file)) {
                $directories[] = $file;
            } else {
                $regularFiles[] = $file;
            }
        }

        // 先渲染目录，再渲染文件
        $items = array_merge($directories, $regularFiles);

        // 渲染根目录和递归渲染子目录
        return $this->renderRootDir($directory) . $this->renderRecursively($items, $directory);
    }

    /**
     * 渲染根目录信息
     *
     * @param string $directory 根目录的路径
     *
     * @return string 渲染后的根目录字符串
     */
    private function renderRootDir(string $directory): string
    {
        return '📂 ' . basename($directory) . "\n";
    }

    /**
     * 递归渲染目录和文件的层级结构
     *
     * @param string[] $items     当前目录下的文件和子目录列表
     * @param string   $directory 当前目录的路径
     * @param int      $level     当前层级的深度
     *
     * @return string 返回渲染后的目录结构
     */
    private function renderRecursively(array $items, string $directory, int $level = 0): string
    {
        $totalItems = count($items);
        $output     = '';

        // 遍历当前目录下的文件和目录
        foreach ($items as $index => $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path                     = $directory . DIRECTORY_SEPARATOR . $item;
            $isLastItemInCurrentLevel = ($index === $totalItems - 1);
            $indentation              = str_repeat('    ', $level);  // 每一层级的缩进

            // 添加竖线连接符（仅对非根目录有效）
            if ($level > 0) {
                $indentation = substr_replace($indentation, '│   ', 0, 4);
            }

            // 设置每项的前缀（目录项使用 "├── " 或 "└── "，文件项使用相同前缀）
            $prefix = $isLastItemInCurrentLevel ? '└── ' : '├── ';

            // 判断当前项是目录还是文件，并进行渲染
            if (is_dir($path)) {
                $output .= $indentation . $prefix . '📂 ' . $item . "\n";
                // 递归处理子目录
                $subItems = scandir($path);
                $output .= $this->renderRecursively($subItems, $path, $level + 1);
            } else {
                $output .= $indentation . $prefix . '📄 ' . $item . "\n";
            }
        }

        return $output;
    }
}
