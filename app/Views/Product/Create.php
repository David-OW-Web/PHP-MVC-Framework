<?php require '../app/Views/Layout/sidebar.php'; ?>

<?php
/** @var $category Category */
/** @var $manufacturer Manufacturer */

// Add column "voraussichtlicher Liefertermin" or table for it
?>

<div class="container-middle">
    <div> <!-- class="form-container" If you want the error messages and the form in the middle -->

        <form class="grid-form form-sm" action="" method="post">
            <?php if(count($data['errors']) != 0): ?>
            <div class="error">
                <?php foreach($data['errors'] as $error => $message): ?>
                <p class="error-message"><?php echo $message; ?></p>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="full">
                <label for="title">Titel</label>
                <input type="text" id="title" name="title">
            </div>

            <div class="full">
                <label for="description">Beschreibung</label>
                <textarea type="text" id="description" name="description"></textarea>
            </div>

            <div class="full">
                <label for="short_description">Kurzbeschreibung</label>
                <textarea type="text" id="short_description" name="short_description"></textarea>
            </div>

            <div class="form-group">
                <label for="amount">Menge</label>
                <input type="text" id="amount" name="amount">
            </div>

            <div class="form-group">
                <label for="price">Preis</label>
                <input type="text" id="price" name="price">
            </div>

            <div class="form-group">
                <label for="category">Kategorie</label>
                <select name="category" id="category">
                    <option value="">Wählen Sie eine Kategorie aus</option>
                    <?php foreach($data['categories'] as $category): ?>
                        <option value="<?php echo $category->category_id; ?>"><?php echo $category->category_title; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="producer">Hersteller</label>
                <select name="producer" id="producer">
                    <option value="">Wählen Sie einen Hersteller aus</option>
                    <?php foreach($data['manufacturers'] as $manufacturer): ?>
                        <option value="<?php echo $manufacturer->manufacturer_id; ?>"><?php echo $manufacturer->manufacturer_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="full">
                <label for="keywords">Schlüsselwörter</label>
                <input type="text" id="keywords" name="keywords">
            </div>

            <button type="submit" name="create">Produkt erstellen</button>
        </form>
    </div>
</div>
