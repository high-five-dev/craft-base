<?php

use PhpCsFixer\Fixer\Alias\ArrayPushFixer;
use PhpCsFixer\Fixer\Alias\MbStrFunctionsFixer;
use PhpCsFixer\Fixer\Alias\SetTypeToCastFixer;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\Basic\NoTrailingCommaInSinglelineFixer;
use PhpCsFixer\Fixer\Basic\SingleLineEmptyBodyFixer;
use PhpCsFixer\Fixer\CastNotation\ModernizeTypesCastingFixer;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer;
use PhpCsFixer\Fixer\Comment\SingleLineCommentStyleFixer;
use PhpCsFixer\Fixer\ControlStructure\IncludeFixer;
use PhpCsFixer\Fixer\ControlStructure\NoAlternativeSyntaxFixer;
use PhpCsFixer\Fixer\FunctionNotation\CombineNestedDirnameFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\FunctionNotation\UseArrowFunctionsFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\SingleLineAfterImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveIssetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveUnsetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DirConstantFixer;
use PhpCsFixer\Fixer\ListNotation\ListSyntaxFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\NoLeadingNamespaceWhitespaceFixer;
use PhpCsFixer\Fixer\Operator\AssignNullCoalescingToCoalesceEqualFixer;
use PhpCsFixer\Fixer\Operator\NewWithParenthesesFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAliasTagFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoPackageFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSummaryFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitInternalClassFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestClassRequiresCoversFixer;
use PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer;
use PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use PhpCsFixer\Fixer\Strict\StrictParamFixer;
use PhpCsFixer\Fixer\StringNotation\ExplicitStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\SimpleToComplexStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use PhpCsFixer\Fixer\StringNotation\StringImplicitBackslashesFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __FILE__
    ])

    ->withRules([
        SingleQuoteFixer::class,
        NoSinglelineWhitespaceBeforeSemicolonsFixer::class,
        SelfAccessorFixer::class,
        FullyQualifiedStrictTypesFixer::class,
        NoBlankLinesAfterClassOpeningFixer::class,
        NoLeadingNamespaceWhitespaceFixer::class,
        BlankLineAfterNamespaceFixer::class,
        CombineConsecutiveIssetsFixer::class,
        CombineConsecutiveUnsetsFixer::class,
        IncludeFixer::class,
        NoTrailingCommaInSinglelineFixer::class,
        ExplicitStringVariableFixer::class,
        SimpleToComplexStringVariableFixer::class,
        NoSuperfluousPhpdocTagsFixer::class,
        NativeFunctionInvocationFixer::class,
        MbStrFunctionsFixer::class,
        ArrayPushFixer::class,
        CombineNestedDirnameFixer::class,
        DirConstantFixer::class,
        ModernizeTypesCastingFixer::class,
        ReturnAssignmentFixer::class,
        SetTypeToCastFixer::class,
        SingleLineAfterImportsFixer::class,
        SingleLineEmptyBodyFixer::class,
        AssignNullCoalescingToCoalesceEqualFixer::class,
        UseArrowFunctionsFixer::class,
        NoUnusedImportsFixer::class
    ])
    ->withSkip([
        StrictComparisonFixer::class,
        NoAlternativeSyntaxFixer::class,
        PhpdocNoAliasTagFixer::class,
        NewWithParenthesesFixer::class,
        PhpdocNoPackageFixer::class,
        PhpdocSummaryFixer::class,
        StrictParamFixer::class,
        PhpdocToCommentFixer::class,
        PhpUnitInternalClassFixer::class,
        PhpUnitTestClassRequiresCoversFixer::class,
        SingleLineCommentStyleFixer::class
    ])
    ->withPreparedSets(psr12: true)
    ->withConfiguredRule(
        StringImplicitBackslashesFixer::class,
        [
            'double_quoted' => 'ignore',
            'heredoc'       => 'ignore',
            'single_quoted' => 'ignore',
        ]
    )
    ->withConfiguredRule(
        ArraySyntaxFixer::class,
        [
            'syntax' => 'short'
        ]
    )
    ->withConfiguredRule(
        ListSyntaxFixer::class,
        [
            'syntax' => 'short'
        ]
    )
    ->withConfiguredRule(
        PhpCsFixer\Fixer\ConstantNotation\NativeConstantInvocationFixer::class,
        [
            'exclude' => [
                'null',
                'false',
                'true',
                'CONNECTION_TIMEOUT',
            ]
        ]
    )
    ->withConfiguredRule(
        PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer::class,
        [
            'elements' => [
                'const'        => 'one',
                'method'       => 'one',
                'property'     => 'one',
                'trait_import' => 'none',
                'case'         => 'none',
            ]
        ]
    )
    ->withConfiguredRule(
        PhpCsFixer\Fixer\Comment\CommentToPhpdocFixer::class,
        [
            'ignored_tags' => [
                'todo'
            ]
        ]
    )
    ->withConfiguredRule(
        PhpCsFixer\Fixer\Operator\OperatorLinebreakFixer::class,
        [
            'position'      => 'beginning',
            'only_booleans' => true,
        ],
    )
    ->withConfiguredRule(
        PhpCsFixer\Fixer\Phpdoc\PhpdocTagTypeFixer::class,
        [
            'tags' => [
                'inheritdoc' => 'annotation',
            ]
        ]
    )
    ->withConfiguredRule(
        PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer::class,
        [
            'equal'            => false,
            'identical'        => false,
            'less_and_greater' => false,
        ]
    )
    ->withConfiguredRule(
        PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer::class,
        [
            'import_classes'   => true,
            'import_constants' => true,
            'import_functions' => true,
        ]
    )
    ->withConfiguredRule(
        PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer::class,
        [
            'default' => 'align_single_space_minimal',
        ]
    )
    ->withConfiguredRule(
        PhpCsFixer\Fixer\FunctionNotation\FopenFlagsFixer::class,
        [
            'b_mode' => true,
        ]
    )
    ->withConfiguredRule(
        PhpCsFixer\Fixer\Import\OrderedImportsFixer::class,
        [
            'sort_algorithm' => 'alpha',
            'imports_order'  => [
                'class',
                'const',
                'function',
            ]
        ]
    )
    ->withConfiguredRule(
        PhpCsFixer\Fixer\Operator\ConcatSpaceFixer::class,
        [
            'spacing' => 'one',
        ]
    )
    ->withConfiguredRule(
        PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer::class,
        [
            'statements' => [
                'break',
                'case',
                'continue',
                'declare',
                'default',
                'do',
                'exit',
                'for',
                'foreach',
                'goto',
                'if',
                'include',
                'include_once',
                'phpdoc',
                'require',
                'require_once',
                'return',
                'switch',
                'throw',
                'try',
                'while',
                'yield',
                'yield_from',
            ],
        ]
    )
    ->withConfiguredRule(
        PhpCsFixer\Fixer\Semicolon\MultilineWhitespaceBeforeSemicolonsFixer::class,
        [
            'strategy' => 'no_multi_line',
        ]
    );
