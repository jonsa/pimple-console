<?php

$fixers = array(
    /** PSR-1 fixers **/
    // PHP code MUST use only UTF-8 without BOM (remove BOM).
    'encoding',
    // PHP code must use the long <?php ? > tags or the short-echo <?= ? > tags; it must not use the other tag variations.
    'short_tag',

    /** PSR-2 fixers **/
    // The body of each structure MUST be enclosed by braces. Braces should be properly placed. Body of braces should be properly indented.
    'braces',
    // The keyword elseif should be used instead of else if so that all control keywords looks like single words.
    'elseif',
    // A file must always end with a single empty line feed.
    'eof_ending',
    // When making a method or function call, there MUST NOT be a space between the method or function name and the opening parenthesis.
    'function_call_space',
    // Spaces should be properly placed in a function declaration.
    'function_declaration',
    // Code MUST use an indent of 4 spaces, and MUST NOT use tabs for indenting.
    'indentation',
    // There MUST be one blank line after the namespace declaration.
    'line_after_namespace',
    // All PHP files must use the Unix LF (linefeed) line ending.
    'linefeed',
    // The PHP constants true, false, and null MUST be in lower case.
    'lowercase_constants',
    // PHP keywords MUST be in lower case.
    'lowercase_keywords',
    // In method arguments and method call, there MUST NOT be a space before each comma and there MUST be one space after each comma.
    'method_argument_space',
    // There MUST be one use keyword per declaration.
    'multiple_use',
    // There MUST NOT be a space after the opening parenthesis. There MUST NOT be a space before the closing parenthesis.
    'parenthesis',
    // The closing ?\> tag MUST be omitted from files containing only PHP.
    'php_closing_tag',
    // Each namespace use MUST go on its own line and there MUST be one blank line after the use statements block.
    'single_line_after_imports',
    // Remove trailing whitespace at the end of non-blank lines.
    'trailing_spaces',
    // Visibility MUST be declared on all properties and methods; abstract and final MUST be declared before the visibility; static MUST be declared after the visibility.
    'visibility',

    /** Symfony fixers **/
    // In array declaration, there MUST NOT be a whitespace before each comma.
    'array_element_no_space_before_comma',
    // In array declaration, there MUST be a whitespace after each comma.
    'array_element_white_space_after_comma',
    // Ensure there is no code on the same line as the PHP open tag and it is followed by a blankline.
    'blankline_after_open_tag',
    // Concatenation should be used without spaces.
//    'concat_without_spaces',
    // Operator => should not be surrounded by multi-line whitespaces.
    'double_arrow_multiline_whitespaces',
    // Remove duplicated semicolons.
    'duplicate_semicolon',
    // A return statement wishing to return nothing should be simply "return".
//    'empty_return',
    // Removes extra empty lines.
    'extra_empty_lines',
    // Add missing space between function's argument and its typehint.
    'function_typehint_space',
    // Include and file path should be divided with a single space. File path should not be placed under brackets.
    'include',
    // Implode function should be used instead of join function.
    'join_function',
    // Remove trailing commas in list function calls.
//    'list_commas',
    // PHP multi-line arrays should have a trailing comma.
    'multiline_array_trailing_comma',
    // The namespace declaration line shouldn't contain leading whitespace.
    'namespace_no_leading_whitespace',
    // All instances created with new keyword must be followed by braces.
//    'new_with_braces',
    // There should be no empty lines after class opening brace.
    'no_blank_lines_after_class_opening',
    // There should not be blank lines between docblock and the documented element.
    'no_empty_lines_after_phpdocs',
    // There should not be space before or after object T_OBJECT_OPERATOR.
//    'object_operator',
    // Binary operators should be surrounded by at least one space.
//    'operators_spaces',
    // Docblocks should have the same indentation as the documented subject.
    'phpdoc_indent',
    // Fix PHPDoc inline tags, make inheritdoc always inline.
    'phpdoc_inline_tag',
    // @access annotations should be omitted from phpdocs.
    'phpdoc_no_access',
    // @return void and @return null annotations should be omitted from phpdocs.
//    'phpdoc_no_empty_return',
    // @package and @subpackage annotations should be omitted from phpdocs.
    'phpdoc_no_package',
    // All items of the @param, @throws, @return, @var, and @type phpdoc tags must be aligned vertically.
//    'phpdoc_params',
    // Scalar types should always be written in the same form. "int", not "integer"; "bool", not "boolean"; "float", not "real" or "double".
    'phpdoc_scalar',
    // Annotations in phpdocs should be grouped together so that annotations of the same type immediately follow each other, and annotations of a different type are separated by a single blank line.
    'phpdoc_separation',
    // Phpdocs short descriptions should end in either a full stop, exclamation mark, or question mark.
    'phpdoc_short_description',
    // Docblocks should only be used on structural elements.
//    'phpdoc_to_comment',
    // Phpdocs should start and end with content, excluding the very first and last line of the docblocks.
    'phpdoc_trim',
    // @type should always be written as @var.
    'phpdoc_type_to_var',
    // The correct case must be used for standard PHP types in phpdoc.
    'phpdoc_types',
    // @var and @type annotations should not contain the variable name.
//    'phpdoc_var_without_name',
    // Pre incrementation/decrementation should be used if possible.
//    'pre_increment',
    // Converts print language construct to echo if possible.
//    'print_to_echo',
    // Remove leading slashes in use clauses.
    'remove_leading_slash_use',
    // Removes line breaks between use statements.
    'remove_lines_between_uses',
    // An empty line feed should precede a return statement.
    'return',
    // Inside a classy element "self" should be preferred to the class name itself.
    'self_accessor',
    // Short cast bool using double exclamation mark should not be used.
    'short_bool_cast',
    // PHP single-line arrays should not have trailing comma.
    'single_array_no_trailing_comma',
    // There should be exactly one blank line before a namespace declaration.
    'single_blank_line_before_namespace',
    // Convert double quotes to single quotes for simple strings.
    'single_quote',
    // Single-line whitespace before closing semicolon are prohibited.
    'spaces_before_semicolon',
    // A single space should be between cast and variable.
    'spaces_cast',
    // Replace all <> with !=.
    'standardize_not_equal',
    // Standardize spaces around ternary operator.
    'ternary_spaces',
    // Arrays should be formatted like function/method arguments, without leading or trailing single line space.
    'trim_array_spaces',
    // Unalign double arrow symbols.
    'unalign_double_arrow',
    // Unalign equals symbols.
    'unalign_equals',
    // Unary operators should be placed adjacent to their operands.
//    'unary_operators_spaces',
    // Removes unneeded parentheses around control statements.
//    'unneeded_control_parentheses',
    // Unused use statements must be removed.
    'unused_use',
    // Remove trailing whitespace at the end of blank lines.
    'whitespacy_lines',

    /** Contrib fixers **/
    // Align double arrow symbols in consecutive lines.
//    'align_double_arrow',
    // Align equals symbols in consecutive lines.
//    'align_equals',
    // Concatenation should be used with at least one whitespace around.
    'concat_with_spaces',
    // Converts echo language construct to print if possible.
//    'echo_to_print',
    // Replace deprecated ereg regular expression functions with preg. Warning! This could change code behavior.
    'ereg_to_preg',
    // Add, replace or remove header comment.
//    'header_comment',
    // Logical NOT operators (!) should have leading and trailing whitespaces.
//    'logical_not_operators_with_spaces',
    // Logical NOT operators (!) should have one trailing whitespace.
//    'logical_not_operators_with_successor_space',
    // Arrays should use the long syntax.
    'long_array_syntax',
    // Multi-line whitespace before closing semicolon are prohibited.
//    'multiline_spaces_before_semicolon',
    // Ensure there is no code on the same line as the PHP open tag.
    'newline_after_open_tag',
    // There should be no blank lines before a namespace declaration.
//    'no_blank_lines_before_namespace',
    // Ordering use statements.
    'ordered_use',
    // Convert PHP4-style constructors to __construct. Warning! This could change code behavior.
//    'php4_constructor',
    // PHPUnit assertion method calls like "->assertSame(true, $foo)" should be written with dedicated method like "->assertTrue($foo)". Warning! This could change code behavior.
//    'php_unit_construct',
    // PHPUnit methods like "assertSame" should be used instead of "assertEquals". Warning! This could change code behavior.
//    'php_unit_strict',
    // Annotations in phpdocs should be ordered so that param annotations come first, then throws annotations, then return annotations.
    'phpdoc_order',
    // @var should always be written as @type.
//    'phpdoc_var_to_type',
    // PHP arrays should use the PHP 5.4 short-syntax.
//    'short_array_syntax',
    // Replace short-echo <?= with long format <?php echo syntax.
//    'short_echo_tag',
    // Comparison should be strict. Warning! This could change code behavior.
//    'strict',
    // Functions should be used with $strict param. Warning! This could change code behavior.
//    'strict_param',
);

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__ . '/src');

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::NONE_LEVEL)
    ->finder($finder)
    ->fixers($fixers)
    ->setUsingCache(true);
