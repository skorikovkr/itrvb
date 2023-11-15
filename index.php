<?php
require_once __DIR__ . '/vendor/autoload.php';

use Root\Skorikov\Models\Post;
use Root\Skorikov\Models\User;
use Root\Skorikov\Models\Comment;

// Реализуйте автозагрузчик классов согласно следующим правилам:
// 1. Разделитель пространства имён преобразуется в разделитель папок: / для Linux и MacOS или \ для Windows. 
// 2. Знак _ в имени класса преобразуется в разделитель папок. 
// 3. Файл с кодом класса имеет расширение .php. 
// spl_autoload_register(function ($class) {
//     $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
//     $file = str_replace('_', DIRECTORY_SEPARATOR, $path) . '.php';
//     if (file_exists($file)) {
//         require "$class.php";
//     }
// });

$user = new User(0, "Kirill", "Skorikov");
$user2 = new User(1, "User2-firstName", "User2-lastName");
$post = new Post(0, $user, "Post Title", "Post text");
$comment = new Comment(0, $user2, $post, "Comment text");

echo $comment;