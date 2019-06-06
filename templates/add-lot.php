  <main>
    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
        <li class="nav__item">
          <a href="all-lots.html"><?= $category['name'] ?></a>
        </li>
        <?php endforeach ?>
      </ul>
    </nav>
    <form class="form form--add-lot container <?= !empty($errors) ? 'form--invalid' : '' ?>" action="add.php" method="post" enctype="multipart/form-data">
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <div class="form__item <?= !empty($errors['title']) ? 'form__item--invalid' : '' ?>">
          <label for="lot-name">Наименование <sup>*</sup></label>
          <input id="lot-name" type="text" name="title" placeholder="Введите наименование лота" value="<?= isset($lot['title']) ? $lot['title'] : '' ?>">
          <span class="form__error"><?= isset($errors['title']) ? $errors['title'] : '' ?></span>
        </div>
        <div class="form__item <?= !empty($errors['category']) ? 'form__item--invalid' : '' ?>">
          <label for="category">Категория <sup>*</sup></label>
          <select id="category" name="category">
            <option value="">Выберите категорию</option>
            <?php foreach ($categories as $category): ?>
              <option value="<?= $category['category_id'] ?>" <?= $category['category_id'] === $lot['category'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
            <?php endforeach ?>
          </select>
          <span class="form__error"><?= isset($errors['category']) ? $errors['category'] : '' ?></span>
        </div>
      </div>
      <div class="form__item form__item--wide <?= !empty($errors['description']) ? 'form__item--invalid' : '' ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="description" placeholder="Напишите описание лота"><?= isset($lot['description']) ? $lot['description'] : '' ?></textarea>
        <span class="form__error"><?= isset($errors['description']) ? $errors['description'] : '' ?></span>
      </div>
      <div class="form__item form__item--file <?= !empty($errors['image']) ? 'form__item--invalid' : '' ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="lot-img" value="" name="image">
          <label for="lot-img">
            Добавить
          </label>
        </div>
        <span class="form__error"><?= isset($errors['image']) ? $errors['image'] : '' ?></span>
      </div>
      <div class="form__container-three">
        <div class="form__item form__item--small <?= !empty($errors['price_start']) ? 'form__item--invalid' : '' ?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" type="text" name="price_start" placeholder="0" value="<?= isset($lot['price_start']) ? $lot['price_start'] : '' ?>">
          <span class="form__error"><?= isset($errors['price_start']) ? $errors['price_start'] : '' ?></span>
        </div>
        <div class="form__item form__item--small <?= !empty($errors['bid_step']) ? 'form__item--invalid' : '' ?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" name="bid_step" placeholder="0" value="<?= isset($lot['bid_step']) ? $lot['bid_step'] : '' ?>">
          <span class="form__error"><?= isset($errors['bid_step']) ? $errors['bid_step'] : '' ?></span>
        </div>
        <div class="form__item <?= !empty($errors['lot_end']) ? 'form__item--invalid' : '' ?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" type="text" name="lot_end" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= isset($lot['lot_end']) ? $lot['lot_end'] : '' ?>">
          <span class="form__error"><?= isset($errors['lot_end']) ? $errors['lot_end'] : '' ?></span>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Добавить лот</button>
    </form>
  </main>