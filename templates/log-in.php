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
    <form class="form container <?= !empty($errors) ? 'form--invalid' : '' ?>" action="log-in.php" method="post">
      <h2>Вход</h2>
      <div class="form__item <?= !empty($errors['e-mail']) ? 'form__item--invalid' : '' ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="e-mail" placeholder="Введите e-mail" value="<?= isset($user['e-mail']) ? $user['e-mail'] : '' ?>">
        <span class="form__error"><?= isset($errors['e-mail']) ? $errors['e-mail'] : '' ?></span>
      </div>
      <div class="form__item form__item--last <?= !empty($errors['password']) ? 'form__item--invalid' : '' ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?= isset($errors['password']) ? $errors['password'] : '' ?></span>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>
  </main>