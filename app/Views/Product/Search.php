<?php

$options = array(
    "asc_title" => "Titel aufsteigend",
    "desc_title" => "Titel absteigend",
    "asc_price" => "Preis aufsteigend",
    "desc_price" => "Preis absteigend"
);






?>

<!--
<form action="" method="get" class="grid-form form-sm">
    <div class="form-group">
        <label for="">Suchtext/Suchbegriff</label>
        <input type="text" name="search">
    </div>

    <div class="form-group">
        <label for="sort">Sortieren nach</label>
    </div>

    <div class="form-group">
        <button type="submit">Suchen</button>
    </div>
</form>
-->

<div class="container-middle">
    <form action="" method="get" class="grid-form form-sm">
        <div class="form-group">
            <label for="">Suchtext/Suchbegriff</label>
            <input type="text" name="search" value="<?php echo @$_GET['search']; ?>">
        </div>

        <div class="form-group">
            <label for="sort">Sortieren nach</label>
            <select name="sort" id="">
                <?php $selected = isset($_GET['sort'])?'selected':''; ?>
                <?php foreach($options as $option => $desc): ?>
                    <option value="<?php echo $option; ?>" <?php if(@$_GET['sort'] == $option): ?> <?php echo $selected; ?> <?php endif; ?>><?php echo $desc; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <button type="submit">Suchen</button>
        </div>
    </form>
    <?php foreach($data['products'] as $product): ?>
    <p><?php echo $product->product_title; ?></p>
    <p><?php echo $product->price; ?></p>
    <?php endforeach; ?>
</div>
