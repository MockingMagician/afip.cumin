<?php

use Mmatweb\Cumin\BackEndFile;
use Mmatweb\Cumin\Cart;
use Mmatweb\Cumin\Item;

require_once __DIR__ . '/../vendor/autoload.php';

$backEnd = new BackEndFile();

try {
    $cart = Cart::getCart($backEnd, '0123456');
} catch (\Throwable $e) {
    $cart = new Cart($backEnd, '0123456');
}

if (isset($_POST['add'])) {
    $cart->addItem($cart->getItem($_POST['add']));
    $cart->save('01234656');
}

?>

<!Doctype html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <?php
            foreach ($cart->getIterator() as $item) {
        ?>
                <li>
                    <?php
                    /** @var Item $item */
                    echo 'Id:' . $item->getId() . ' | ' . $item->getPrice() . '€ | Qty:' . $item->getQuantity()
                    ?>
                    <form method="post">
                        <input type="hidden" name="add" value="<?php echo $item->getId(); ?>">
                        <button>add</button>
                    </form>
                </li>
        <?php
            }
        ?>

    </body>
</html>
