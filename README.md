# Directory Tree Viewer
> Simple and elegant PHP library for visualizing directory tree structure

![License](https://img.shields.io/github/license/hizpark/directory-tree-viewer?style=flat-square)
![Latest Version](https://img.shields.io/packagist/v/hizpark/directory-tree-viewer?style=flat-square)
![CI](https://github.com/hizpark/directory-tree-viewer/actions/workflows/ci.yml/badge.svg?style=flat-square)
![Code Style](https://img.shields.io/badge/code_style-PSR--12-lightgrey?style=flat-square)
![Static Analysis](https://img.shields.io/badge/static_analysis-PHPStan-blue?style=flat-square)
![Tests](https://img.shields.io/badge/tests-PHPUnit-brightgreen?style=flat-square)
[![codecov](https://codecov.io/gh/hizpark/directory-tree-viewer/branch/main/graph/badge.svg)](https://codecov.io/gh/hizpark/directory-tree-viewer)

Render directory structures as tree views in PHP — ideal for CLI tools, logging, or documentation.

## ✨ 特性

- 支持类 Unix 的 `tree` 结构输出（含图标）
- 自动识别文件与目录并排序
- 支持递归遍历子目录
- 返回纯文本字符串，适合 CLI 或日志输出
- 可集成进脚手架、构建流程、项目分析等场景

## 📦 安装

```bash
composer require hizpark/directory-tree-viewer
```

## 📂 目录结构

```txt
📂 directory-tree-viewer
├── 📂 src
│   └── 📄 DirectoryTreeViewer.php
├── 📂 tests
│   └── 📄 DirectoryTreeViewerTest.php
├── 📄 composer.json
└── 📄 README.md
```

## 🚀 用法示例

### 示例：渲染指定目录结构

```php
use Hizpark\DirectoryTreeViewer\DirectoryTreeViewer;

$viewer = new DirectoryTreeViewer();
echo $viewer->render(__DIR__);
```

## 📐 接口说明

### render(string $directory): string

> 渲染指定目录的树状结构，返回字符串形式的表示

```php
public function render(string $directory): string
```

## 🎯 代码风格

使用 PHP-CS-Fixer 工具检查代码风格：

```bash
composer cs:chk
```

使用 PHP-CS-Fixer 工具自动修复代码风格问题：

```bash
composer cs:fix
```

## 🔍 静态分析

使用 PHPStan 工具进行静态分析，确保代码的质量和一致性：

```bash
composer stan
```

## ✅ 单元测试

执行 PHPUnit 单元测试：

```bash
composer test
```

执行 PHPUnit 单元测试并生成代码覆盖率报告：

```bash
composer test:coverage
```

## 🤝 贡献指南

欢迎 Issue 与 PR，建议遵循以下流程：

1. Fork 仓库
2. 创建新分支进行开发
3. 提交 PR 前请确保测试通过、风格一致
4. 提交详细描述

## 📝 License

MIT License. See the [LICENSE](LICENSE) file for details.
