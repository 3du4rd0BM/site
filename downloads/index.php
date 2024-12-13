<?php
// Define o usuário e senha para autenticação
$auth_user = 'admin';
$auth_pass = 'nimda';

// Verifica se a autenticação é necessária
$is_local = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);
if (!$is_local && (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != $auth_user || $_SERVER['PHP_AUTH_PW'] != $auth_pass)) {
    header('WWW-Authenticate: Basic realm="Área Restrita"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Autenticação requerida.';
    exit;
}

// Defina o diretório raiz para listar os arquivos
$dir = './';

// Recupera a lista de arquivos e diretórios
$files = scandir($dir);

// Remove os diretórios "." e ".." da lista
$files = array_diff($files, array('..', '.','index.php'));

// Define a lista de extensões de arquivos que são imagens
$imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'svg'];

// Define a lista de extensões de arquivos compactados
$compressedExtensions = ['7z', 'zip', 'rar', 'tar', 'gz', 'bz2'];

// Define um array com os ícones para cada extensão
$icons = [
    'jpg' => 'photo',
    'jpeg' => 'photo',
    'gif' => 'photo',
    'png' => 'photo',
    'svg' => 'photo',
    'php' => 'php',
    'html' => 'html',
    'js' => 'javascript',
    'css' => 'css',
    '7z' => 'folder_zip',
    'zip' => 'folder_zip',
    'rar' => 'folder_zip',
    'tar' => 'folder_zipe',
    'gz' => 'folder_zip',
    'bz2' => 'folder_zip',
    'exe' => 'grid_view',
    'apk' => 'adb',
    'pdf' => 'picture_as_pdf',
];

// Obter o nome do servidor
$serverName = $_SERVER['SERVER_NAME'];
?>
<?php include '../top.php';?>
    <div class="container">
    	<div class="section">
    		<div class="row">
    		
        <h3 class="center-align">Arquivos em:</h3>
		
		      <ul class="collection with-header">
                <li class="collection-header"><h4><?php echo strtoupper($serverName) ?></h4></li>
                <?php foreach ($files as $file) :
    				$extension = pathinfo($file, PATHINFO_EXTENSION);
    				$icon = '';
    				$mime_type = mime_content_type($dir . $file);
    
    				if (is_dir($file)) {
    					$icon = 'folder_open';
    				} elseif (in_array($extension, $imageExtensions)) {
    					$icon = 'panorama';
    				} elseif (in_array($extension, $compressedExtensions)) {
    					$icon = 'folder_zip';
    				} else {
    					switch ($extension) {
    					    case 'exe':
    					    case 'apk':
    					    case 'html':
    						case 'php':
    						case 'js':
    						case 'css':
    							$icon = isset($icons[$extension]) ? $icons[$extension] : 'code';
    							break;
    						default:
    							$icon = 'cloud_download';
    							break;
    					}
    				}
    			?>
                
                <li class="collection-item">
                	<div>
                		<b><?php echo $file ?></b> - <i class="grey-text"><?php echo $mime_type ?></i>
                		<a href="<?php echo $dir . $file ?>" class="secondary-content">
                			<i class="material-icons blue-text waves-effect waves-light"><?php echo $icon ?></i>
                		</a>
                	</div>
                </li>
                
                <?php endforeach; ?>
                
              </ul>
		
			</div>
		</div>
	</div>
<?php include '../bottom.php';?>
