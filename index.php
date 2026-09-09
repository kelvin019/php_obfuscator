<?php

/*
 * @Obfuscator version: 0.1
 * @Project Started: 01/18/2023
 * @author: Raivis Petersons ( Narvulkan )
 * @TryOut Website: https://php_obf.com/
 *
*/

try {

    # Set Error Reporting All Except E_NOTICE
    error_reporting(E_ALL & ~E_NOTICE);

    # Start OB
    ob_start();

    # Start Session
    session_start();

    # Set Default Encoding
    @ini_set('default_charset', 'utf-8');

    # Set Default TimeZone
    date_default_timezone_set('UTC');

    # OBF Version
    define('version', '0.1');
    define('max_upload_size_bytes', 67108864);
    define('max_upload_size_label', '64 MB');

    # Obfuscation Safety Rules (standard)
    $obfRules = array(
        'allowed_extensions' => array('php'),
        'exclude_path_hints' => array(
            '/views/', '/templates/', '/theme/', '/themes/', '/public/', '/html/',
            '/assets/', '/storage/', '/cache/', '/vendor/', '/node_modules/', '/tests/', '/test/'
        ),
        'exclude_filename_hints' => array(
            '.blade.php', '.tpl.php', '.phtml', '.twig.php'
        ),
        'inline_html_max_text' => 120
    );

    # Donate Page Display Thanks Message
    if (isset($_GET['thanks'])) {

        $setThanks = '<div class="alert alert-success alert-white rounded"><div class="icon"><i class="fa fa-beer" aria-hidden="true"></i></div><strong> Thanks </strong> For Supporting This Project, Wish you all the best :) </div>';

    } else {
        $setThanks = '';
    };

    $sourceCode = '';
    $flashNoticeHtml = '';
    $resultModalHtml = '';
    $downloadResultHtml = '';
    $activeInputTab = 'text';
    $selectedSecurityMode = 'secure';
    $defaultHeaderTop = 'Kastech Network Limited'.PHP_EOL
        .'Kelvin Ugbana'.PHP_EOL
        .'Version 1.0'.PHP_EOL
        .'https://kelvin.ugbana.com'.PHP_EOL
        .'Copyright 2026. All rights reserved';
    $headerTop = $defaultHeaderTop;

    # Load One-Time Flash State After Redirect So Refresh Will Not Re-Run The POST
    if (isset($_SESSION['obf_flash']) && is_array($_SESSION['obf_flash'])) {

        $flashData = $_SESSION['obf_flash'];
        unset($_SESSION['obf_flash']);

        $sourceCode = isset($flashData['source_code']) ? $flashData['source_code'] : '';
        $flashNoticeHtml = isset($flashData['notice_html']) ? $flashData['notice_html'] : '';
        $resultModalHtml = isset($flashData['result_modal_html']) ? $flashData['result_modal_html'] : '';
        $downloadResultHtml = isset($flashData['download_result_html']) ? $flashData['download_result_html'] : '';
        $activeInputTab = isset($flashData['active_input_tab']) ? $flashData['active_input_tab'] : 'text';
        $selectedSecurityMode = isset($flashData['security_mode']) ? $flashData['security_mode'] : 'secure';
        $selectedSecurityMode = isset($flashData['security_mode']) ? $flashData['security_mode'] : 'secure';
        $headerTop = isset($flashData['header_top']) ? $flashData['header_top'] : $defaultHeaderTop;

    };

    # Load Template Head And Top Body Sections
    echo '
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Primary Meta -->
	<title>PHP Code Obfuscator — Free Online PHP Obfuscation Tool</title>
	<meta name="description" content="Free online PHP code obfuscator. Protect your PHP source code by obfuscating variables, functions, strings, and whitespace. Supports single files and ZIP archives.">
	<meta name="keywords" content="PHP obfuscator, obfuscate PHP code, PHP code protection, PHP encoder, source code protection, PHP minifier, online PHP obfuscator">
	<meta name="author" content="Raivis Petersons (Narvulkan)">
	<meta name="robots" content="index, follow">
	<link rel="canonical" href="https://php_obf.com/">

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://php_obf.com/">
	<meta property="og:title" content="PHP Code Obfuscator — Free Online PHP Obfuscation Tool">
	<meta property="og:description" content="Protect your PHP source code instantly. Obfuscate variables, functions, strings, and whitespace. Supports single files and ZIP archives.">
	<meta property="og:image" content="https://php_obf.com/assets/og-image.png">

	<!-- Twitter Card -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="PHP Code Obfuscator — Free Online PHP Obfuscation Tool">
	<meta name="twitter:description" content="Protect your PHP source code instantly. Obfuscate variables, functions, strings, and whitespace. Supports single files and ZIP archives.">
	<meta name="twitter:image" content="https://php_obf.com/assets/og-image.png">

	<!-- JSON-LD Structured Data -->
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "WebApplication",
		"name": "PHP Code Obfuscator",
		"url": "https://php_obf.com/",
		"description": "Free online PHP code obfuscator. Protect your PHP source code by obfuscating variables, functions, strings, and whitespace.",
		"applicationCategory": "DeveloperApplication",
		"operatingSystem": "Any",
		"offers": {
			"@type": "Offer",
			"price": "0",
			"priceCurrency": "USD"
		},
		"author": {
			"@type": "Person",
			"name": "Raivis Petersons"
		}
	}
	</script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link href="assets/style.css" rel="stylesheet">
	<script>
		(function () {
			function toggleRenameSettings(mode) {
				var show = mode !== "cpanel";
				var fnCard = document.getElementById("setting-rename-functions");
				var varCard = document.getElementById("setting-rename-variables");
				if (fnCard) { fnCard.style.display = show ? "" : "none"; }
				if (varCard) { varCard.style.display = show ? "" : "none"; }
			}

			document.addEventListener("change", function (e) {
				if (e.target && e.target.name === "security_mode") {
					toggleRenameSettings(e.target.value);
				}
			});

			document.addEventListener("DOMContentLoaded", function () {
				var checked = document.querySelector("input[name=\"security_mode\"]:checked");
				toggleRenameSettings(checked ? checked.value : "secure");
			});
		})();
	</script>
</head>
<body>

	<header class="site-header">
		<div class="header-icon"><i class="fas fa-shield-alt"></i></div>
		<h1>PHP Code Obfuscator</h1>
		<p>Protect your PHP source code with advanced obfuscation. Supports echo &amp; print — no open/close tag juggling required.</p>
	</header>

	<main class="main-wrap">

		'.$setThanks.'
		'.$flashNoticeHtml.'

		<form action="" method="post" enctype="multipart/form-data" id="56853475437543">
			<input name="obf_start" type="hidden"/>

			<div class="split-layout">
			<div class="split-left">

			<div class="card">
				<div class="card-header input-tabs" role="tablist">
					<button type="button" class="input-tab input-tab--active" id="tab-text" role="tab" aria-selected="true" aria-controls="panel-text" data-tab="text">
						<i class="fas fa-code"></i> Paste Code
					</button>
					<button type="button" class="input-tab" id="tab-upload" role="tab" aria-selected="false" aria-controls="panel-upload" data-tab="upload">
						<i class="fas fa-file-archive"></i> Upload File / Zip
					</button>
				</div>

				<div class="card-body tab-panel tab-panel--active" id="panel-text" role="tabpanel" aria-labelledby="tab-text">
					<textarea name="obf_code_single" placeholder="Paste your PHP source code here..." id="editing" spellcheck="false">'.$sourceCode.'</textarea>
				</div>

				<div class="card-body tab-panel" id="panel-upload" role="tabpanel" aria-labelledby="tab-upload" hidden>
					<label for="file-upload" class="upload-dropzone">
						<input id="file-upload" name="UploadedSourceFile" type="file" accept=".php,.zip,application/zip,application/x-zip-compressed" />
						<span class="upload-dropzone__icon"><i class="fas fa-cloud-upload-alt"></i></span>
						<span class="upload-dropzone__title">Choose a <code>.php</code> file or <code>.zip</code> archive</span>
						<span class="upload-dropzone__meta" id="file_name_output">Nothing selected yet</span>
					</label>
					<p class="upload-help">Maximum upload size: '.max_upload_size_label.'. ZIP uploads keep non-PHP assets and obfuscate PHP files.</p>
				</div>
			</div>

			</div><!-- /.split-left -->
			<div class="split-right">

			<div class="card">
				<div class="card-header">
					<i class="fas fa-sliders-h"></i>
					<h3>Obfuscation Settings</h3>
				</div>
				<div class="card-body">
					<div class="settings-grid">

						<div class="setting-card">
							<div class="setting-header">
								<span class="setting-title">Security Mode</span>
							</div>
							<div class="setting-fields">
								<div class="field-group" style="grid-column: 1 / -1;">
									<label style="display:block; margin-bottom:6px;">Choose profile</label>
									<label style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
										<input type="radio" name="security_mode" value="secure" '.(($selectedSecurityMode === 'secure') ? 'checked' : '').' />
										Extremely Secured (may trigger cPanel scanners)
									</label>
									<label style="display:flex; align-items:center; gap:8px;">
										<input type="radio" name="security_mode" value="cpanel" '.(($selectedSecurityMode === 'cpanel') ? 'checked' : '').' />
										cPanel Friendly (rename variables only, no eval)
									</label>
									<small style="display:block; color:#6b7280; margin-top:6px;">
										In cPanel Friendly mode, function/variable renaming toggles are locked to safe defaults.
									</small>
								</div>
							</div>
						</div>

						<div class="setting-card">
							<div class="setting-header">
								<span class="setting-title">Add File Header</span>
							</div>
							<textarea name="header_top" id="header_top" placeholder="* My Code Name
* @version 0.1
* @author Narvulkan
* https://my.website.com/
* @copyright (c) 2023 MyWeb, All Rights Reserved" spellcheck="false">'.$headerTop.'</textarea>
						</div>

						<div class="setting-card" id="setting-rename-functions" style="'.(($selectedSecurityMode === 'cpanel') ? 'display:none;' : '').'">
							<div class="setting-header">
								<span class="setting-title">Rename Functions</span>
								<label class="toggle-switch">
									<input type="checkbox" name="rn_fnc_name" '.(($selectedSecurityMode === 'cpanel') ? 'disabled' : '').' />
									<span class="toggle-slider"></span>
								</label>
							</div>
							<div class="setting-fields">
								<div class="field-group">
									<label>Min Length</label>
									<input name="rn_fnc_name_len_min" value="32" />
								</div>
								<div class="field-group">
									<label>Max Length</label>
									<input name="rn_fnc_name_len_max" value="64" />
								</div>
							</div>
						</div>

						<div class="setting-card" id="setting-rename-variables" style="'.(($selectedSecurityMode === 'cpanel') ? 'display:none;' : '').'">
							<div class="setting-header">
								<span class="setting-title">Rename Variables</span>
								<label class="toggle-switch">
									<input type="checkbox" name="rn_var_name" '.(($selectedSecurityMode === 'cpanel') ? 'disabled' : '').' />
									<span class="toggle-slider"></span>
								</label>
							</div>
							<div class="setting-fields">
								<div class="field-group">
									<label>Min Length</label>
									<input name="rn_var_name_len_min" value="32" />
								</div>
								<div class="field-group">
									<label>Max Length</label>
									<input name="rn_var_name_len_max" value="64" />
								</div>
							</div>
						</div>

						<div class="setting-card">
							<div class="setting-header">
								<span class="setting-title">Remove Spaces &amp; Tabs</span>
								<label class="toggle-switch">
									<input type="checkbox" name="use_space_tab_rem" checked />
									<span class="toggle-slider"></span>
								</label>
							</div>
						</div>

						<div class="setting-card">
							<div class="setting-header">
								<span class="setting-title">HTML Encode Tags</span>
								<label class="toggle-switch">
									<input type="checkbox" name="use_html_ende_tags" checked />
									<span class="toggle-slider"></span>
								</label>
							</div>
							<label class="checkbox-label">
								<input type="checkbox" name="use_html_ende_comments" checked />
								<span>Add random HTML comments</span>
							</label>
						</div>

						<div class="setting-card">
							<div class="setting-header">
								<span class="setting-title">Encode / Decode Code</span>
								<label class="toggle-switch">
									<input type="checkbox" name="use_encode_w_eval" checked />
									<span class="toggle-slider"></span>
								</label>
							</div>
							<div class="setting-fields">
								<div class="field-group field-group--wide">
									<label>Encoding Type</label>
									<select name="use_encode_w_eval_type">
										<option value="5" selected>openssl_encrypt + hmac + chunked loader</option>
									</select>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="submit-wrap">
				<button type="button" class="btn-obfuscate" id="btn_obf_start" onclick="document.getElementById(\'56853475437543\').submit();">
					<i class="fas fa-compress-alt"></i> Start Obfuscation
				</button>
			</div>

			</div><!-- /.split-right -->
			</div><!-- /.split-layout -->

		</form>

		<div id="result_output_div">
	';

    # Function To Generate Random Variable And Function Names
    function generateName($len)
    {

        # Random Mixed Character To Use
        $characters = '______0123456789_____ABCDEFG__HIJKLMNO_______0123456789_____PQRSTUVW__XYZ';

        $charactersLength = strlen($characters);
        $randomString = '_';

        # Loop & Add Letters/Symbols In One String
        for ($i = 0; $i < $len; $i++) {

            $randomString .= $characters[rand(0, $charactersLength - 1)];

        };

        return $randomString;

    };

    # Function To Generate Random Spaces For Haotic Results
    function generateRandSpaces($len)
    {

        # Random Spacing Create
        $randspaces = '';

        for ($i = 0; $i < $len; $i++) {

            $randspaces .= ' ';

        };

        return $randspaces;

    };

    # Split String Into Random Chunks To Avoid One Big Static Payload Block
    function splitIntoRandomChunks($value, $minLen = 8, $maxLen = 24)
    {

        if ($value === '') {
            return array('');
        };

        $chunks = array();
        $offset = 0;
        $valueLength = strlen($value);

        while ($offset < $valueLength) {

            $remaining = $valueLength - $offset;
            $chunkLength = min(mt_rand($minLen, $maxLen), $remaining);
            $chunks[] = substr($value, $offset, $chunkLength);
            $offset += $chunkLength;

        };

        return $chunks;

    };

    # Convert Array To A Valid PHP Array String
    function buildPhpArrayLiteral($items)
    {

        $quotedItems = array();

        foreach ($items as $item) {
            $quotedItems[] = var_export($item, true);
        };

        return 'array('.implode(',', $quotedItems).')';

    };

    # Build A chr() Chain So Runtime Function Names Are Not Stored Plainly
    function buildChrChain($value)
    {

        $parts = array();
        $valueLength = strlen($value);

        for ($i = 0; $i < $valueLength; $i++) {
            $parts[] = 'chr('.ord($value[$i]).')';
        };

        return implode('.', $parts);

    };

    # More Advanced Runtime Loader Than Plain base64+eval
    function buildAdvancedEvalLoader($phpCodeCombined)
    {

        if (!function_exists('openssl_encrypt') || !function_exists('openssl_decrypt') || !function_exists('hash_hmac')) {
            return false;
        };

        $compressedCode = gzdeflate($phpCodeCombined, 9);
        $key = openssl_random_pseudo_bytes(32);
        $iv = openssl_random_pseudo_bytes(16);
        $encryptedCode = openssl_encrypt($compressedCode, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

        if ($encryptedCode === false) {
            return false;
        };

        $payload = base64_encode($encryptedCode);
        $payloadHash = hash_hmac('sha256', $encryptedCode, $key);

        $payloadArrayVar = generateName(20);
        $keyArrayVar = generateName(20);
        $ivArrayVar = generateName(20);
        $hashArrayVar = generateName(20);
        $payloadVar = generateName(20);
        $keyVar = generateName(20);
        $ivVar = generateName(20);
        $hashVar = generateName(20);
        $base64DecodeFnVar = generateName(20);
        $opensslDecryptFnVar = generateName(20);
        $hashHmacFnVar = generateName(20);
        $gzinflateFnVar = generateName(20);
        $cipherVar = generateName(20);
        $calculatedHashVar = generateName(20);
        $decryptedVar = generateName(20);

        $loader = '<?php ';
        $loader .= '$'.$payloadArrayVar.' = '.buildPhpArrayLiteral(splitIntoRandomChunks($payload)).';';
        $loader .= '$'.$keyArrayVar.' = '.buildPhpArrayLiteral(splitIntoRandomChunks(base64_encode($key), 4, 10)).';';
        $loader .= '$'.$ivArrayVar.' = '.buildPhpArrayLiteral(splitIntoRandomChunks(base64_encode($iv), 4, 10)).';';
        $loader .= '$'.$hashArrayVar.' = '.buildPhpArrayLiteral(splitIntoRandomChunks($payloadHash, 8, 16)).';';
        $loader .= '$'.$payloadVar.' = implode("", $'.$payloadArrayVar.');';
        $loader .= '$'.$keyVar.' = base64_decode(implode("", $'.$keyArrayVar.'));';
        $loader .= '$'.$ivVar.' = base64_decode(implode("", $'.$ivArrayVar.'));';
        $loader .= '$'.$hashVar.' = implode("", $'.$hashArrayVar.');';
        $loader .= '$'.$base64DecodeFnVar.' = '.buildChrChain('base64_decode').';';
        $loader .= '$'.$opensslDecryptFnVar.' = '.buildChrChain('openssl_decrypt').';';
        $loader .= '$'.$hashHmacFnVar.' = '.buildChrChain('hash_hmac').';';
        $loader .= '$'.$gzinflateFnVar.' = '.buildChrChain('gzinflate').';';
        $loader .= '$'.$cipherVar.' = $'.$base64DecodeFnVar.'($'.$payloadVar.');';
        $loader .= 'if ($'.$cipherVar.' === false) { return; };';
        $loader .= '$'.$calculatedHashVar.' = $'.$hashHmacFnVar.'("sha256", $'.$cipherVar.', $'.$keyVar.');';
        $loader .= 'if ($'.$calculatedHashVar.' !== $'.$hashVar.') { return; };';
        $loader .= '$'.$decryptedVar.' = $'.$opensslDecryptFnVar.'($'.$cipherVar.', "AES-256-CBC", $'.$keyVar.', OPENSSL_RAW_DATA, $'.$ivVar.');';
        $loader .= 'if ($'.$decryptedVar.' === false) { return; };';
        $loader .= '$'.$decryptedVar.' = $'.$gzinflateFnVar.'($'.$decryptedVar.');';
        $loader .= 'if ($'.$decryptedVar.' === false) { return; };';
        $loader .= 'eval($'.$decryptedVar.');';
        $loader .= ' ?>';

        return $loader;

    };

    # Recursively Remove Directories Created During Upload Processing
    function deletePathRecursive($path)
    {

        if ($path === '' || !file_exists($path)) {
            return;
        };

        if (is_file($path) || is_link($path)) {
            @unlink($path);
            return;
        };

        $items = scandir($path);
        foreach ($items as $item) {

            if ($item === '.' || $item === '..') {
                continue;
            };

            deletePathRecursive($path.DIRECTORY_SEPARATOR.$item);

        };

        @rmdir($path);

    };

    # Create A Zip Archive From A Directory
    function createZipFromDirectory($sourceDir, $destinationZip)
    {

        $zipArchive = new ZipArchive();
        if ($zipArchive->open($destinationZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return false;
        };

        $sourceDir = rtrim($sourceDir, DIRECTORY_SEPARATOR);
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourceDir, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {

            $fullPath = $item->getPathname();
            $relativePath = substr($fullPath, strlen($sourceDir) + 1);

            if ($item->isDir()) {
                $zipArchive->addEmptyDir(str_replace(DIRECTORY_SEPARATOR, '/', $relativePath));
            } else {
                $zipArchive->addFile($fullPath, str_replace(DIRECTORY_SEPARATOR, '/', $relativePath));
            };

        };

        $zipArchive->close();
        return true;

    };

    # Detect Real Inline Template Markup Outside PHP Tags
    function hasUnsafeInlineTemplateMarkup($phpCode)
    {
        $inlineTextLimit = 120;
        if (isset($GLOBALS['obfRules']) && is_array($GLOBALS['obfRules']) && isset($GLOBALS['obfRules']['inline_html_max_text'])) {
            $inlineTextLimit = (int) $GLOBALS['obfRules']['inline_html_max_text'];
        }

        $tokens = token_get_all($phpCode);

        foreach ($tokens as $token) {

            if (!is_array($token) || $token[0] !== T_INLINE_HTML) {
                continue;
            };

            $inlineHtml = trim($token[1]);
            if ($inlineHtml === '') {
                continue;
            };

            if (preg_match('/<(?:!DOCTYPE\s+html|html\b|head\b|body\b|style\b|script\b|link\b|div\b|span\b|form\b|input\b|table\b|section\b|main\b|header\b|footer\b|nav\b|article\b)/i', $inlineHtml) === 1) {
                return true;
            };

            $visibleText = trim(strip_tags($inlineHtml));
            if ($visibleText !== '' && strlen($visibleText) > $inlineTextLimit) {
                return true;
            };

        };

        return false;

    };

    # Prefer Pure Backend PHP Files For Obfuscation
    function isPurePhpSafeToObfuscate($phpCode, $relativePath = '')
    {

        $normalizedPath = str_replace('\\', '/', strtolower($relativePath));
        $excludedPathHints = array('/views/', '/templates/', '/theme/', '/themes/', '/public/', '/html/');
        $excludedFilenameHints = array();

        if (isset($GLOBALS['obfRules']) && is_array($GLOBALS['obfRules'])) {
            if (isset($GLOBALS['obfRules']['exclude_path_hints']) && is_array($GLOBALS['obfRules']['exclude_path_hints'])) {
                $excludedPathHints = $GLOBALS['obfRules']['exclude_path_hints'];
            }
            if (isset($GLOBALS['obfRules']['exclude_filename_hints']) && is_array($GLOBALS['obfRules']['exclude_filename_hints'])) {
                $excludedFilenameHints = $GLOBALS['obfRules']['exclude_filename_hints'];
            }
        }

        foreach ($excludedPathHints as $excludedPathHint) {
            if ($normalizedPath !== '' && strpos($normalizedPath, $excludedPathHint) !== false) {
                return false;
            };
        };

        if ($normalizedPath !== '') {
            foreach ($excludedFilenameHints as $excludedFilenameHint) {
                if (str_ends_with($normalizedPath, strtolower($excludedFilenameHint))) {
                    return false;
                }
            }
        }

        if (hasUnsafeInlineTemplateMarkup($phpCode)) {
            return false;
        };

        return true;

    };

    # Run PHP Lint Against A Generated File Before Returning It
    function lintPhpFile($filePath)
    {

        $phpBinary = defined('PHP_BINARY') ? PHP_BINARY : '';
        if ($phpBinary === '' || !function_exists('exec')) {
            return array(
                'ok' => null,
                'output' => 'Preflight syntax check is unavailable because the PHP CLI binary or exec() is not available.'
            );
        };

        $command = escapeshellarg($phpBinary).' -l '.escapeshellarg($filePath).' 2>&1';
        $outputLines = array();
        $exitCode = 1;
        exec($command, $outputLines, $exitCode);

        return array(
            'ok' => ($exitCode === 0),
            'output' => trim(implode(PHP_EOL, $outputLines))
        );

    };

    # Build A Stable Random Name Map Entry
    function getMappedName($originalName, &$nameMap, $minLength, $maxLength, $prefix = '')
    {

        if (isset($nameMap[$originalName])) {
            return $nameMap[$originalName];
        };

        $generatedLength = mt_rand($minLength, $maxLength);
        $nameMap[$originalName] = $prefix.generateName($generatedLength);

        return $nameMap[$originalName];

    };

    # Reserved Method Names Should Never Be Renamed
    function isReservedFunctionName($name)
    {

        static $reservedNames = array(
            '__construct' => true,
            '__destruct' => true,
            '__call' => true,
            '__callstatic' => true,
            '__get' => true,
            '__set' => true,
            '__isset' => true,
            '__unset' => true,
            '__sleep' => true,
            '__wakeup' => true,
            '__serialize' => true,
            '__unserialize' => true,
            '__tostring' => true,
            '__invoke' => true,
            '__set_state' => true,
            '__clone' => true,
            '__debuginfo' => true,
            '__autoload' => true
        );

        return isset($reservedNames[strtolower($name)]);

    };

    # Collect Declared Functions And Methods From Source Files
    function collectDeclaredFunctionNamesFromCode($phpCode)
    {

        $tokens = token_get_all($phpCode);
        $declaredFunctions = array();
        $tokenCount = count($tokens);
        $braceStack = array();
        $pendingStructure = null;
        $classLikeDepth = 0;

        for ($index = 0; $index < $tokenCount; $index++) {

            $token = $tokens[$index];
            $isEnumToken = defined('T_ENUM') && is_array($token) && $token[0] === T_ENUM;
            if (is_array($token) && ($token[0] === T_CLASS || $token[0] === T_INTERFACE || $token[0] === T_TRAIT || $isEnumToken)) {
                $pendingStructure = 'class_like';
            } elseif ($token === '{') {
                $braceStack[] = $pendingStructure;
                if ($pendingStructure === 'class_like') {
                    $classLikeDepth++;
                };
                $pendingStructure = null;
            } elseif ($token === '}') {
                $lastStructure = array_pop($braceStack);
                if ($lastStructure === 'class_like' && $classLikeDepth >= 1) {
                    $classLikeDepth--;
                };
            };

            if (!is_array($token) || $token[0] !== T_FUNCTION) {
                continue;
            };

            if ($classLikeDepth >= 1) {
                continue;
            };

            $lookAhead = $index + 1;
            while ($lookAhead < $tokenCount) {
                $nextToken = $tokens[$lookAhead];

                $isAmpersandToken = defined('T_AMPERSAND_NOT_FOLLOWED_BY_VAR_OR_VARARG') && $nextToken[0] === T_AMPERSAND_NOT_FOLLOWED_BY_VAR_OR_VARARG;
                if (is_array($nextToken) && ($nextToken[0] === T_WHITESPACE || $isAmpersandToken || $nextToken[0] === T_COMMENT || $nextToken[0] === T_DOC_COMMENT)) {
                    $lookAhead++;
                    continue;
                };

                if (!is_array($nextToken) && $nextToken === '&') {
                    $lookAhead++;
                    continue;
                };

                if (is_array($nextToken) && $nextToken[0] === T_STRING && !isReservedFunctionName($nextToken[1])) {
                    $declaredFunctions[$nextToken[1]] = $nextToken[1];
                };

                break;

            };

        };

        return $declaredFunctions;

    };

    # Transform PHP Source Safely Using Tokens Instead Of Regex
    function transformPhpSource($phpCode, $options, &$globalFunctionMap, &$globalVariableMap)
    {

        $tokens = token_get_all($phpCode);
        $tokenCount = count($tokens);
        $resultParts = array();
        $functionMapLower = array();
        $variableMapLower = array();
        $functionMin = max(1, min(200, (int)$options['function_min']));
        $functionMax = max($functionMin, min(200, (int)$options['function_max']));
        $variableMin = max(1, min(200, (int)$options['variable_min']));
        $variableMax = max($variableMin, min(200, (int)$options['variable_max']));
        $stripComments = !empty($options['strip_comments']);
        $compactWhitespace = !empty($options['compact_whitespace']);
        $previousSignificantTokenText = null;
        $previousSignificantTokenId = null;
        $insideGlobalDeclaration = false;
        $globalVariableNames = array();

        foreach ($globalFunctionMap as $originalFunctionName => $mappedFunctionName) {
            $functionMapLower[strtolower($originalFunctionName)] = $mappedFunctionName;
        };

        foreach ($globalVariableMap as $originalVariableName => $mappedVariableName) {
            $variableMapLower[strtolower($originalVariableName)] = $mappedVariableName;
        };

        $pendingFunctionName = false;

        for ($index = 0; $index < $tokenCount; $index++) {

            $token = $tokens[$index];

            if (is_string($token)) {
                $resultParts[] = $token;
                if ($insideGlobalDeclaration && $token === ';') {
                    $insideGlobalDeclaration = false;
                };
                if (trim($token) !== '') {
                    $previousSignificantTokenText = $token;
                    $previousSignificantTokenId = null;
                };
                continue;
            };

            $tokenId = $token[0];
            $tokenText = $token[1];

            if ($tokenId === T_OPEN_TAG) {
                continue;
            };

            if ($tokenId === T_OPEN_TAG_WITH_ECHO) {
                $resultParts[] = 'echo ';
                $previousSignificantTokenText = 'echo';
                $previousSignificantTokenId = T_ECHO;
                continue;
            };

            if ($tokenId === T_CLOSE_TAG) {
                $shouldTerminateStatement = (
                    $previousSignificantTokenText !== null &&
                    !in_array($previousSignificantTokenText, array(';', ':', '{', '}', ','), true)
                );

                if ($shouldTerminateStatement) {
                    $resultParts[] = ';';
                    $previousSignificantTokenText = ';';
                    $previousSignificantTokenId = null;
                };

                continue;
            };

            if ($stripComments && ($tokenId === T_COMMENT || $tokenId === T_DOC_COMMENT)) {
                continue;
            };

            if ($tokenId === T_GLOBAL) {
                $insideGlobalDeclaration = true;
            };

            if ($tokenId === T_INLINE_HTML) {
                if ($tokenText === '') {
                    continue;
                };

                $resultParts[] = 'echo '.var_export($tokenText, true).';';
                $previousSignificantTokenText = ';';
                $previousSignificantTokenId = null;
                continue;
            };

            if ($compactWhitespace && $tokenId === T_WHITESPACE) {
                $resultParts[] = ' ';
                continue;
            };

            if ($tokenId === T_FUNCTION) {
                $pendingFunctionName = true;
                $resultParts[] = $tokenText;
                $previousSignificantTokenText = $tokenText;
                $previousSignificantTokenId = $tokenId;
                continue;
            };

            if ($tokenId === T_VARIABLE && !empty($options['rename_variables'])) {
                $variableName = substr($tokenText, 1);
                $variableNameLower = strtolower($variableName);
                $superGlobals = array(
                    'GLOBALS' => true,
                    '_SERVER' => true,
                    '_GET' => true,
                    '_POST' => true,
                    '_FILES' => true,
                    '_COOKIE' => true,
                    '_SESSION' => true,
                    '_REQUEST' => true,
                    '_ENV' => true,
                    '_PHP_ERRMSG' => true,
                    'http_response_header' => true,
                    'argc' => true,
                    'argv' => true,
                    'this' => true
                );
                $isPropertyDeclaration = in_array($previousSignificantTokenId, array(T_PUBLIC, T_PROTECTED, T_PRIVATE, T_VAR), true);

                if ($insideGlobalDeclaration) {
                    $globalVariableNames[$variableNameLower] = true;
                    $resultParts[] = $tokenText;
                    $previousSignificantTokenText = $tokenText;
                    $previousSignificantTokenId = $tokenId;
                    continue;
                };

                if (!isset($superGlobals[$variableName]) && !isset($globalVariableNames[$variableNameLower]) && !$isPropertyDeclaration) {
                    if (!isset($variableMapLower[$variableNameLower])) {
                        $mappedVariableName = getMappedName($variableName, $globalVariableMap, $variableMin, $variableMax, '$');
                        $variableMapLower[$variableNameLower] = $mappedVariableName;
                    };

                    $resultParts[] = $variableMapLower[$variableNameLower];
                    $previousSignificantTokenText = $variableMapLower[$variableNameLower];
                    $previousSignificantTokenId = $tokenId;
                    continue;
                };
            };

            if ($tokenId === T_STRING) {
                if ($pendingFunctionName && !empty($options['rename_functions']) && !isReservedFunctionName($tokenText) && isset($functionMapLower[strtolower($tokenText)])) {
                    $functionNameLower = strtolower($tokenText);
                    $resultParts[] = $functionMapLower[$functionNameLower];
                    $previousSignificantTokenText = $functionMapLower[$functionNameLower];
                    $previousSignificantTokenId = $tokenId;
                    $pendingFunctionName = false;
                    continue;
                };

                $pendingFunctionName = false;

                if (!empty($options['rename_functions'])) {
                    $functionNameLower = strtolower($tokenText);
                    if (isset($functionMapLower[$functionNameLower])) {
                        $previousIndex = $index - 1;
                        while ($previousIndex >= 0 && is_array($tokens[$previousIndex]) && $tokens[$previousIndex][0] === T_WHITESPACE) {
                            $previousIndex--;
                        };

                        $nextIndex = $index + 1;
                        while ($nextIndex < $tokenCount && is_array($tokens[$nextIndex]) && $tokens[$nextIndex][0] === T_WHITESPACE) {
                            $nextIndex++;
                        };

                        $previousToken = ($previousIndex >= 0) ? $tokens[$previousIndex] : null;
                        $nextToken = ($nextIndex < $tokenCount) ? $tokens[$nextIndex] : null;
                        $isFunctionCall = ($nextToken === '(');
                        $isMethodAccess = ($previousToken === '->' || $previousToken === '::' || (is_array($previousToken) && ($previousToken[0] === T_NEW || $previousToken[0] === T_FUNCTION || $previousToken[0] === T_CONST || $previousToken[0] === T_OBJECT_OPERATOR || $previousToken[0] === T_DOUBLE_COLON)));

                        if ($isFunctionCall && !$isMethodAccess) {
                            $resultParts[] = $functionMapLower[$functionNameLower];
                            $previousSignificantTokenText = $functionMapLower[$functionNameLower];
                            $previousSignificantTokenId = $tokenId;
                            continue;
                        };
                    };
                };
            } else {
                $pendingFunctionName = false;
            };

            $resultParts[] = $tokenText;
            if ($tokenId !== T_WHITESPACE && $tokenId !== T_COMMENT && $tokenId !== T_DOC_COMMENT) {
                $previousSignificantTokenText = $tokenText;
                $previousSignificantTokenId = $tokenId;
            };

        };

        return trim(implode('', $resultParts));

    };

    # Defined Error And Success For Better Visuals
    $Err_S = '<div class="alert alert-warning alert-white rounded"><div class="icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div><strong>Alert!</strong>';
    $Err_E = '</div>';
    $Succ_S = '<div class="alert alert-success alert-white rounded"><div class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div><strong>Success!</strong>';
    $Succ_E = '</div>';

    # Set Default
    $scrollBottom = 0;

    # Incoming POST Processing & File Obfuscation
    if (isset($_POST['obf_start'])) {

        # A JS Scroll TO Bottom Init Key After Post Sent ( unknown if there is a better way )
        $scrollBottom = 1;
        $sourceCode = htmlentities($_POST['obf_code_single']);
        $flashNoticeHtml = '';
        $activeInputTab = 'text';
        $selectedSecurityMode = isset($_POST['security_mode']) ? $_POST['security_mode'] : 'secure';
        $selectedSecurityMode = isset($_POST['security_mode']) ? $_POST['security_mode'] : 'secure';

        # Read Security Mode (standardized)
        $securityMode = isset($_POST['security_mode']) ? $_POST['security_mode'] : 'secure';

        # Normalize checkbox inputs because unchecked boxes are omitted from POST
        $_POST['rn_fnc_name'] = isset($_POST['rn_fnc_name']);
        $_POST['rn_var_name'] = isset($_POST['rn_var_name']);
        $_POST['use_space_tab_rem'] = isset($_POST['use_space_tab_rem']);
        $_POST['use_html_ende_tags'] = isset($_POST['use_html_ende_tags']);
        $_POST['use_html_ende_comments'] = isset($_POST['use_html_ende_comments']);
        $_POST['use_encode_w_eval'] = isset($_POST['use_encode_w_eval']);

        # Apply Security Mode Overrides (cpanel-friendly vs secure)
        if ($securityMode === 'cpanel') {
            $_POST['rn_fnc_name'] = false;
            $_POST['rn_var_name'] = true;
            $_POST['use_encode_w_eval'] = false;
            $_POST['use_space_tab_rem'] = true;
            $_POST['use_html_ende_tags'] = true;
            $_POST['use_html_ende_comments'] = true;
        }

        # Create Unique Session While Processing Files
        define("MySessionID", rand(100, 9999999));

        # Set Error Code Default
        $error = 0;
        $lintFailures = array();
        $lintWarnings = array();
        $preflightWarningHtml = '';
        $skippedTemplatePhpFiles = array();
        $obfuscatedPhpFileCount = 0;

        # Check If TextArea Is Empty Else Ignore Zip Upload
        $uploadedSourceName = isset($_FILES['UploadedSourceFile']['name']) ? trim($_FILES['UploadedSourceFile']['name']) : '';
        $is_OBF_Single = ($_POST['obf_code_single'] === '') ? 0 : 1;
        $is_OBF_File = ($uploadedSourceName === '') ? 0 : 1;
        $is_OBF_Zip = 0;
        $uploadedFileExtension = strtolower(pathinfo($uploadedSourceName, PATHINFO_EXTENSION));

        if ($is_OBF_File == 1 && $is_OBF_Single == 0) {
            $activeInputTab = 'upload';
        };

        # Load TextArea Content OR Zip File Depending On Added Info
        if ($is_OBF_Single == 1) {

            # Set Folder Name For Single OBF Case
            $obf_path_unpacked = 'files/';
            $obf_path_packed = 'files/';

            # Single OBF Content Stored To PHP File To Avoid Duplicated Process For Each Upload Case And As TXT Instead Of PHP TO Avoid PHP File Execute On Webhost
            file_put_contents($obf_path_unpacked."obf_single_".MySessionID.".txt", $_POST['obf_code_single']);
            chmod($obf_path_unpacked."obf_single_".MySessionID.".txt", 0755);
            $for_array_file_loop = array('obf_single_'.MySessionID.'.txt');

        } elseif ($is_OBF_File == 1) {

            # Set Folder Name For Multiple File OBF Case
            $obf_path_unpacked = 'files/unpacked/';
            $obf_path_packed = 'files/packed/';
            $sessionUnpackedDir = $obf_path_unpacked.MySessionID.'/';
            $sessionPackedDir = $obf_path_packed.MySessionID.'/';
            $uploadedTmpName = $_FILES['UploadedSourceFile']['tmp_name'];
            $uploadedError = $_FILES['UploadedSourceFile']['error'];

            if ($uploadedError !== UPLOAD_ERR_OK || !is_uploaded_file($uploadedTmpName)) {
                $error = 104;
                goto End;
            };

            if ($_FILES['UploadedSourceFile']['size'] > max_upload_size_bytes) {
                $error = 100;
                goto End;
            };

            if (!is_dir($sessionUnpackedDir)) {
                mkdir($sessionUnpackedDir, 0755, true);
            };

            if (!is_dir($sessionPackedDir)) {
                mkdir($sessionPackedDir, 0755, true);
            };

            # Check Uploaded File Type And Prepare PHP File List

            $for_array_file_loop = array();
            if ($uploadedFileExtension === 'php') {

                $targetPhpName = preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($uploadedSourceName));
                if ($targetPhpName === '' || strtolower(pathinfo($targetPhpName, PATHINFO_EXTENSION)) !== 'php') {
                    $targetPhpName = 'uploaded_'.MySessionID.'.php';
                };

                if (!move_uploaded_file($uploadedTmpName, $sessionUnpackedDir.$targetPhpName)) {
                    $error = 104;
                    goto End;
                };

                $uploadedPhpSource = file_get_contents($sessionUnpackedDir.$targetPhpName);
                if ($uploadedPhpSource === false || !isPurePhpSafeToObfuscate($uploadedPhpSource, $targetPhpName)) {
                    $error = 108;
                    goto End;
                };

                $for_array_file_loop[] = MySessionID.'/'.$targetPhpName;

            } elseif ($uploadedFileExtension === 'zip') {

                $zip_file = new ZipArchive();
                $result = $zip_file->open($uploadedTmpName);
                if ($result !== true) {
                    $error = 102;
                    goto End;
                };

                $php_cnt = 0;
                for ($in = 0; $in < $zip_file->numFiles; $in++) {

                    $file_info = $zip_file->statIndex($in);
                    $entryName = str_replace('\\', '/', $file_info['name']);

                    if (substr($entryName, -1) === '/') {
                        continue;
                    };

                    if (strpos($entryName, '../') !== false || strpos($entryName, '..\\') !== false || strpos($entryName, ':') !== false) {
                        continue;
                    };

                    if (strtolower(pathinfo($entryName, PATHINFO_EXTENSION)) === 'php') {
                        $for_array_file_loop[] = MySessionID.'/'.$entryName;
                        $php_cnt++;
                    };
                };

                if ($php_cnt === 0) {
                    $zip_file->close();
                    $error = 101;
                    goto End;
                };

                if (!$zip_file->extractTo($sessionUnpackedDir)) {
                    $zip_file->close();
                    $error = 102;
                    goto End;
                };

                $zip_file->close();
                $is_OBF_Zip = 1;

                $for_array_file_loop = array();
                $iterator = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($sessionUnpackedDir, FilesystemIterator::SKIP_DOTS),
                    RecursiveIteratorIterator::SELF_FIRST
                );

                foreach ($iterator as $item) {

                    if (!$item->isFile()) {
                        continue;
                    };

                    $sourcePath = $item->getPathname();
                    if (strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION)) !== 'php') {
                        continue;
                    };

                    $relativePath = substr($sourcePath, strlen($sessionUnpackedDir));
                    $phpSource = file_get_contents($sourcePath);

                    if ($phpSource === false) {
                        $skippedTemplatePhpFiles[] = $relativePath;
                        continue;
                    };

                    if (isPurePhpSafeToObfuscate($phpSource, $relativePath)) {
                        $for_array_file_loop[] = MySessionID.'/'.$relativePath;
                    } else {
                        $skippedTemplatePhpFiles[] = $relativePath;
                    };

                };

                if (count($for_array_file_loop) === 0) {
                    $error = 108;
                    goto End;
                };

            } else {

                $error = 105;
                goto End;

            };

        } else {

            # Both TextArea And Upload Are Empty, Exit Code.
            $error = 103;
            goto End;

        };

        $functionRenameMap = array();
        $variableRenameMap = array();
        $transformOptions = array(
            'rename_functions' => $_POST['rn_fnc_name'],
            'rename_variables' => $_POST['rn_var_name'],
            'function_min' => $_POST['rn_fnc_name_len_min'],
            'function_max' => $_POST['rn_fnc_name_len_max'],
            'variable_min' => $_POST['rn_var_name_len_min'],
            'variable_max' => $_POST['rn_var_name_len_max'],
            'html_tags' => $_POST['use_html_ende_tags'],
            'html_comments' => $_POST['use_html_ende_comments'],
            'strip_comments' => true,
            'compact_whitespace' => $_POST['use_space_tab_rem']
        );

        if ($_POST['rn_fnc_name']) {
            foreach ($for_array_file_loop as $array_file) {
                $sourceFileContents = file_get_contents($obf_path_unpacked.''.$array_file);
                $declaredFunctions = collectDeclaredFunctionNamesFromCode($sourceFileContents);
                foreach ($declaredFunctions as $declaredFunction) {
                    getMappedName($declaredFunction, $functionRenameMap, max(1, min(200, (int)$_POST['rn_fnc_name_len_min'])), max(max(1, min(200, (int)$_POST['rn_fnc_name_len_min'])), min(200, (int)$_POST['rn_fnc_name_len_max'])));
                };
            };
        };

        $obfuscatedPhpFileCount = count($for_array_file_loop);

        # Keep Non-PHP Assets In The Encoded Output So ZIP Builds Preserve Full Site Structure
        if ($is_OBF_Zip == 1) {

            $selectedPhpLookup = array_fill_keys($for_array_file_loop, true);
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($sessionUnpackedDir, FilesystemIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($iterator as $item) {

                if (!$item->isFile()) {
                    continue;
                };

                $sourcePath = $item->getPathname();
                $relativePath = substr($sourcePath, strlen($sessionUnpackedDir));
                $targetPath = $sessionPackedDir.$relativePath;
                $targetDir = dirname($targetPath);

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                };

                $selectedKey = MySessionID.'/'.$relativePath;
                if (isset($selectedPhpLookup[$selectedKey])) {
                    continue;
                };

                copy($sourcePath, $targetPath);

            };

        };

        # Run Foreach To Loop All Files Of ZIP To Obfuscate Or Single File Obfuscate
        foreach ($for_array_file_loop as $array_file) {

            # Load File
            $getFileToClean = file_get_contents($obf_path_unpacked.''.$array_file);
            $php_code_combined = transformPhpSource($getFileToClean, $transformOptions, $functionRenameMap, $variableRenameMap);

            # Adding Header On Top Of File With
            $php_result_code = '';

            if ($_POST['header_top'] !== "") {

                $php_result_code .= '<?php'.PHP_EOL;
                $php_result_code .= '/*'.PHP_EOL;
                $php_result_code .= $_POST['header_top'].''.PHP_EOL;
                $php_result_code .= '*/'.PHP_EOL;
                $php_result_code .= '?>'.PHP_EOL;

            };

            # Decode Encode Code
            if ($_POST['use_encode_w_eval'] == false) {

                $php_result_code .= $php_code_combined;

            } else {

                if ($_POST['use_encode_w_eval_type'] === '5') {

                    $advancedLoader = buildAdvancedEvalLoader($php_code_combined);
                    $php_result_code .= ($advancedLoader === false) ? $php_code_combined : $advancedLoader;

                } else {

                    $php_result_code .= $php_code_combined;

                };

            };

            # Save File TO Packed Folder With Original Name
            $packedTargetDir = dirname($obf_path_packed.''.$array_file);
            if (!is_dir($packedTargetDir)) {
                mkdir($packedTargetDir, 0755, true);
            };
            file_put_contents($obf_path_packed.''.$array_file, $php_result_code);
            chmod($obf_path_packed.''.$array_file, 0755);

            $lintResult = lintPhpFile($obf_path_packed.''.$array_file);
            if ($lintResult['ok'] === false) {
                $lintFailures[] = array(
                    'file' => $array_file,
                    'message' => $lintResult['output']
                );
            } elseif ($lintResult['ok'] === null) {
                $lintWarnings[] = array(
                    'file' => $array_file,
                    'message' => $lintResult['output']
                );
            };

        };

        if (count($lintFailures) >= 1) {
            $error = 107;
            goto End;
        };

        if (count($lintWarnings) >= 1) {
            $warningCount = count($lintWarnings);
            $preflightWarningHtml = $Err_S.' Preflight syntax check could not run on this host, so output was generated without CLI lint verification.';
            if ($warningCount > 1) {
                $preflightWarningHtml .= ' This affected '.$warningCount.' generated files.';
            };
            $preflightWarningHtml .= $Err_E;
        };

        if ($is_OBF_Zip == 1 && count($skippedTemplatePhpFiles) >= 1) {
            $preflightWarningHtml .= $Err_S.' '.count($skippedTemplatePhpFiles).' mixed PHP template file(s) were copied unchanged because they contain HTML, CSS, or JavaScript and are not safe to obfuscate.'.$Err_E;
        };

        if ($is_OBF_Zip == 1 && $obfuscatedPhpFileCount >= 1) {
            $preflightWarningHtml .= $Succ_S.' '.$obfuscatedPhpFileCount.' pure PHP file(s) were obfuscated successfully.'.$Succ_E;
        };

        # Get Single File Content Else Zip Url For Others
        if ($is_OBF_Single == 1) {

            $flashNoticeHtml = $Succ_S.' Code Has Been Obfuscated'.$Succ_E;
            $flashNoticeHtml .= $preflightWarningHtml;

            $Single_File_Content = file_get_contents($obf_path_packed.''.$array_file);

            $resultModalHtml = '
				<div class="result-modal is-open" id="resultModal" aria-hidden="false">
					<div class="result-modal__backdrop" data-close-result-modal="true"></div>
					<div class="result-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="resultModalTitle">
						<div class="result-modal__header">
							<div>
								<span class="result-label"><i class="fas fa-check-circle"></i> Obfuscated Code Result</span>
								<h2 id="resultModalTitle">Your obfuscated PHP is ready</h2>
							</div>
							<button type="button" class="result-modal__close" id="closeResultModal" aria-label="Close result modal">
								<i class="fas fa-times"></i>
							</button>
						</div>
						<div class="result-modal__actions">
							<button type="button" class="result-copy-btn" id="copyResultCode">
								<i class="far fa-copy"></i> Copy Code
							</button>
							<span class="result-copy-status" id="copyResultStatus" aria-live="polite"></span>
						</div>
						<textarea id="resutOut" spellcheck="false">'.$Single_File_Content.'</textarea>
					</div>
				</div>
			';

            # Delete Single Files
            unlink($obf_path_packed.''.$array_file);
            if (file_exists($obf_path_unpacked.''.$array_file)) {
                unlink($obf_path_unpacked.''.$array_file);
            };

        } elseif ($is_OBF_File == 1 && $is_OBF_Zip == 0) {

            $flashNoticeHtml = $Succ_S.' File Has Been Obfuscated'.$Succ_E;
            $flashNoticeHtml .= $preflightWarningHtml;

            $downloadFilePath = $obf_path_packed.''.$array_file;
            $downloadFileName = basename($downloadFilePath);
            $resultModalHtml = '
				<div class="result-modal is-open" id="resultModal" aria-hidden="false">
					<div class="result-modal__backdrop" data-close-result-modal="true"></div>
					<div class="result-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="resultModalTitle">
						<div class="result-modal__header">
							<div>
								<span class="result-label"><i class="fas fa-download"></i> Obfuscated File Ready</span>
								<h2 id="resultModalTitle">Your obfuscated PHP file is ready</h2>
							</div>
							<button type="button" class="result-modal__close" id="closeResultModal" aria-label="Close result modal">
								<i class="fas fa-times"></i>
							</button>
						</div>
						<div class="result-modal__content">
							<p class="download-copy">Your uploaded PHP file has been obfuscated and is ready to download.</p>
							<a class="download-btn" href="'.htmlentities($downloadFilePath).'" download="'.htmlentities($downloadFileName).'">
								<i class="fas fa-file-download"></i> Download '.htmlentities($downloadFileName).'
							</a>
						</div>
					</div>
				</div>
			';

            deletePathRecursive($obf_path_unpacked.MySessionID);

        } elseif ($is_OBF_Zip == 1) {

            $downloadZipName = 'obfuscated_'.MySessionID.'.zip';
            $downloadZipPath = $obf_path_packed.$downloadZipName;

            if (createZipFromDirectory($obf_path_packed.MySessionID, $downloadZipPath) === false) {
                $error = 106;
                goto End;
            };

            $flashNoticeHtml = $Succ_S.' Files Have Been Obfuscated & Zipped'.$Succ_E;
            $flashNoticeHtml .= $preflightWarningHtml;

            $resultModalHtml = '
				<div class="result-modal is-open" id="resultModal" aria-hidden="false">
					<div class="result-modal__backdrop" data-close-result-modal="true"></div>
					<div class="result-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="resultModalTitle">
						<div class="result-modal__header">
							<div>
								<span class="result-label"><i class="fas fa-file-archive"></i> Obfuscated Zip Ready</span>
								<h2 id="resultModalTitle">Your obfuscated zip is ready</h2>
							</div>
							<button type="button" class="result-modal__close" id="closeResultModal" aria-label="Close result modal">
								<i class="fas fa-times"></i>
							</button>
						</div>
						<div class="result-modal__content">
							<p class="download-copy">Your archive has been processed. Download the obfuscated zip below.</p>
							<a class="download-btn" href="'.htmlentities($downloadZipPath).'" download="'.htmlentities($downloadZipName).'">
								<i class="fas fa-file-download"></i> Download '.htmlentities($downloadZipName).'
							</a>
						</div>
					</div>
				</div>
			';

            deletePathRecursive($obf_path_unpacked.MySessionID);
            deletePathRecursive($obf_path_packed.MySessionID);

        };

        # Error Code Processing To Nofity User Of Issue.
        if ($error !== 0) {

            End:

            if ($error == 100) {
                $flashNoticeHtml = $Err_S.' File size is too big. Maximum allowed upload is '.max_upload_size_label.'.'.$Err_E;
            } elseif ($error == 101) {
                $flashNoticeHtml = $Err_S.' Uploaded zip did not contain any PHP files to obfuscate'.$Err_E;
            } elseif ($error == 102) {
                $flashNoticeHtml = $Err_S.' Opened Zip Was Not Valid And Failed To Extract'.$Err_E;
            } elseif ($error == 103) {
                $flashNoticeHtml = $Err_S.' Both TextArea And Upload Are Empty'.$Err_E;
            } elseif ($error == 104) {
                $flashNoticeHtml = $Err_S.' Uploaded file could not be processed. Please try again with a valid PHP file or zip archive'.$Err_E;
            } elseif ($error == 105) {
                $flashNoticeHtml = $Err_S.' Only .php files and .zip archives are supported for upload'.$Err_E;
            } elseif ($error == 106) {
                $flashNoticeHtml = $Err_S.' The obfuscated files were created, but the download zip could not be generated'.$Err_E;
            } elseif ($error == 107) {
                $failureCount = count($lintFailures);
                $flashNoticeHtml = $Err_S.' Preflight syntax check failed for one or more generated files. Nothing was released until these issues are fixed.';
                if ($failureCount > 1) {
                    $flashNoticeHtml .= ' '.$failureCount.' files failed the preflight check.';
                };
                if (isset($lintFailures[0]['message']) && $lintFailures[0]['message'] !== '') {
                    $flashNoticeHtml .= '<div style="margin-top:10px;"><pre style="white-space:pre-wrap;margin-top:6px;background:#fff7e8;border:1px solid #eed8a6;padding:10px;border-radius:6px;overflow:auto;">'.htmlentities($lintFailures[0]['message']).'</pre></div>';
                };
                $flashNoticeHtml .= $Err_E;
            } elseif ($error == 108) {
                $flashNoticeHtml = $Err_S.' Only pure PHP backend files are obfuscated. Mixed PHP template/view files that contain HTML, CSS, or JavaScript are skipped to avoid breaking the page'.$Err_E;
            } else {
                $flashNoticeHtml = $Err_S.' Something went wrong, Check your files & try again!'.$Err_E;
            };

        };

        if (isset($varArrayGlb['var_saved'])) {
            unset($varArrayGlb['var_saved']);
        };

        if (isset($varArrayGlb['func_saved'])) {
            unset($varArrayGlb['func_saved']);
        };

        unset($setVarArrCase);
        unset($sesFuncArray);

        $_SESSION['obf_flash'] = array(
            'source_code' => $sourceCode,
            'notice_html' => $flashNoticeHtml,
            'result_modal_html' => $resultModalHtml,
            'download_result_html' => $downloadResultHtml,
            'active_input_tab' => $activeInputTab,
            'security_mode' => $securityMode,
            'header_top' => isset($_POST['header_top']) ? $_POST['header_top'] : $headerTop,
        );

        $redirectQuery = array();
        if (isset($_GET['thanks'])) {
            $redirectQuery['thanks'] = $_GET['thanks'];
        };

        $redirectUrl = basename($_SERVER['PHP_SELF']);
        if (count($redirectQuery) >= 1) {
            $redirectUrl .= '?'.http_build_query($redirectQuery);
        };

        if (ob_get_length() !== false) {
            ob_clean();
        };

        header('Location: '.$redirectUrl);
        exit;

    };

    # Footer Section Of Template
    echo'</div>

	</main>

	'.$downloadResultHtml.'
	'.$resultModalHtml.'

	<footer class="site-footer">
		<div>copyright &copy; '.date('Y').' <b>obfuscator.kastechnet.com</b>, All Rights Reserved</div>
		<div>All visual aspects coded by Kastech Network except for font-awesome icons.</div>
	</footer>

	<script>
	$(document).ready(function() {
		var resultModal = $("#resultModal");
		var resultTextarea = document.getElementById("resutOut");
		var initialInputTab = "'.$activeInputTab.'";

		function closeResultModal() {
			if (!resultModal.length) {
				return;
			}

			resultModal.removeClass("is-open").attr("aria-hidden", "true");
			$("body").removeClass("modal-open");
		}

		function openResultModal() {
			if (!resultModal.length) {
				return;
			}

			resultModal.addClass("is-open").attr("aria-hidden", "false");
			$("body").addClass("modal-open");
		}

		// Input tabs
		$(".input-tab").on("click", function() {
			var tab = $(this).data("tab");
			$(".input-tab").removeClass("input-tab--active").attr("aria-selected", "false");
			$(this).addClass("input-tab--active").attr("aria-selected", "true");
			$(".tab-panel").removeClass("tab-panel--active").attr("hidden", true);
			$("#panel-" + tab).addClass("tab-panel--active").removeAttr("hidden");
		});

		if (initialInputTab === "upload") {
			$("#tab-upload").trigger("click");
		}

		$("input#file-upload").change(function() {
			var ele = document.getElementById($("input#file-upload").attr("id"));
			var result = ele.files;
			if (result && result.length > 0) {
				$("#file_name_output").html(result[0].name);
			} else {
				$("#file_name_output").html("Nothing selected yet");
			}
		});

		$(document).on("click", "[data-close-result-modal], #closeResultModal", function() {
			closeResultModal();
		});

		$(document).on("keydown", function(event) {
			if (event.key === "Escape") {
				closeResultModal();
			}
		});

		$("#copyResultCode").on("click", function() {
			if (!resultTextarea) {
				return;
			}

			var codeToCopy = resultTextarea.value;
			var statusNode = $("#copyResultStatus");

			function showCopyStatus(message) {
				statusNode.text(message).addClass("is-visible");
				window.setTimeout(function() {
					statusNode.removeClass("is-visible");
				}, 2200);
			}

			if (navigator.clipboard && window.isSecureContext) {
				navigator.clipboard.writeText(codeToCopy).then(function() {
					showCopyStatus("Code copied.");
				}).catch(function() {
					resultTextarea.focus();
					resultTextarea.select();
					resultTextarea.setSelectionRange(0, resultTextarea.value.length);
					if (document.execCommand("copy")) {
						showCopyStatus("Code copied.");
					} else {
						showCopyStatus("Copy failed. Press Ctrl/Cmd+C.");
					}
				});
			} else {
				resultTextarea.focus();
				resultTextarea.select();
				resultTextarea.setSelectionRange(0, resultTextarea.value.length);
				if (document.execCommand("copy")) {
					showCopyStatus("Code copied.");
				} else {
					showCopyStatus("Copy failed. Press Ctrl/Cmd+C.");
				}
			}
		});

		if (resultModal.length) {
			openResultModal();
		}

		if('.$scrollBottom.' == 1 && !resultModal.length){
			$("html,body").animate({scrollTop: document.body.scrollHeight},"slow");
		};
	});
</script>
</body>
</html>
';

} catch (Exception $err) {
    echo $err->getMessage();
};
