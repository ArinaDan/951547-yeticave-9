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
    <section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">
       <?php foreach ($user_bids as $user_bid): ?>
        <tr class="rates__item  <?= ((strtotime($user_bid['lot_end']) < time()) && !($user_bid['winner_id'] === $user_bid['user_id'])) ? 'rates__item--end' : '' ?> <?= (strtotime($user_bid['lot_end']) < time()) && ($user_bid['winner_id'] === $user_bid['user_id']) ? 'rates__item--win' : '' ?>">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?= $user_bid['image'] ?>" width="54" height="40" alt="<?= $user_bid['title'] ?>">
            </div>
            <div>
            <h3 class="rates__title"><a href="lot.php?id=<?= $user_bid['lot_id'] ?>"><?= $user_bid['title'] ?></a></h3>
             <p><?= ($user_bid['winner_id'] === $user_bid['user_id']) ? $user_bid['contacts'] : '' ?></p>
             </div>
          </td>
          <td class="rates__category">
            <?= $user_bid['name'] ?>
          </td>
          <td class="rates__timer">
            <div class="timer <?= (strtotime($user_bid['lot_end']) < time()) ? 'timer--end' : add_lot_status_class($user_bid['lot_end']) ?> <?= ($user_bid['winner_id'] === $user_bid['user_id']) ? 'timer--win' : '' ?>"><?= (strtotime($user_bid['lot_end']) < time()) ? 'Торги окончены' : get_formatted_lot_end($user_bid['lot_end']) ?></div>
          </td>
          <td class="rates__price">
            <?= price_format($user_bid['price']) ?>
          </td>
          <td class="rates__time">
            <?= get_bid_expire($user_bid) ?>
          </td>
        </tr>
        <?php endforeach ?>
      </table>
    </section>
  </main>