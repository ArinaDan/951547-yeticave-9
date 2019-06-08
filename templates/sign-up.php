  <main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
            <li class="nav__item">
                <a href="all-lots.php?name=<?= $category['code'] ?>"><?= $category['name'] ?></a>
            </li>
        <?php endforeach ?>
        </ul>
    </nav>
    <form class="form container <?= !empty($errors) ? 'form--invalid' : '' ?>" action="sign-up.php" method="post" autocomplete="off">
      <h2>Регистрация нового аккаунта</h2>
      <div class="form__item <?= !empty($errors['e-mail']) ? 'form__item--invalid' : '' ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="e-mail" placeholder="Введите e-mail">
        <span class="form__error"><?= isset($errors['e-mail']) ? $errors['e-mail'] : '' ?></span>
      </div>
      <div class="form__item <?= !empty($errors['password']) ? 'form__item--invalid' : '' ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?= isset($errors['password']) ? $errors['password'] : '' ?></span>
      </div>
      <div class="form__item <?= !empty($errors['name']) ? 'form__item--invalid' : '' ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя">
        <span class="form__error"><?= isset($errors['name']) ? $errors['name'] : '' ?></span>
      </div>
      <div class="form__item <?= !empty($errors['contacts']) ? 'form__item--invalid' : '' ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="contacts" placeholder="Напишите как с вами связаться"></textarea>
        <span class="form__error"><?= isset($errors['contacts']) ? $errors['contacts'] : '' ?></span>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="log-in.php">Уже есть аккаунт</a>
    </form>
  </main>