<div class="list">
  <section>
    <div class="message">
    <?php
      if (!empty($params['error'])) {
        switch ($params['error']) {
          case 'noteNotFound':
            echo 'Notatka nie została znaleziona';
            break;
          case "missingNoteId":
            echo "Nieprawidłowe id notatki";
            break;
        }
      }
      ?>
      <?php
      if (!empty($params['before'])) {
        switch ($params['before']) {
          case 'created':
            echo 'Notatka została utworzona !!!';
            break;
          case 'edited':
            echo 'Notatka została zedytowana!!!';
            break;
          case 'deleted':
            echo 'Notatka została usunięta !!!';
            break;
        }
      }
      ?>
    </div>


    <?php
    $sort = $params['sort'];
    
    $by = $sort['by'] ?? 'title';
    $order = $sort['order'] ?? 'desc';

    $page = $params['page'];

    $size = $page['size'] ?? 10;
    $number = $page['number'] ?? 1;
    $pages = $page['pages'] ?? 1;

    $phrase = $params['phrase'] ?? null;
    $phraseType = $params['phraseType'] ?? 'title';

    ?>

    <div>
      <form action="/" class="settings-form" method="GET">
        <div>
          <label>Wyszukaj:<input type="text" name="phrase" value="<?php echo $phrase; ?>" placeholder="fraza lub data w formacie RRRR-MM-DD"></label>
          <div>Po:</div>
            <label>Tytule: <input type="radio" name="phraseType" value="title" <?php echo $phraseType === 'title' ? 'checked' : ''; ?>></label>
            <label>dacie: <input type="radio" name="phraseType" value="created" <?php echo $phraseType === 'created' ? 'checked' : ''; ?>></label>
        </div>
        <div>
          <div>Sortuj po:</div>
          <label>Tytule: <input type="radio" name="sortby" value="title" <?php echo $by === 'title' ? 'checked' : ''; ?>></label>
          <label>Dacie: <input type="radio" name="sortby" value="created"<?php echo $by === 'created' ? 'checked' : ''; ?>></label>
        </div>
        <div>
          <div>Kierunek Sortowania</div>
          <label>Rosnąco: <input type="radio" name="sortorder" value="asc"<?php echo $order === 'asc' ? 'checked' : ''; ?>></label>
          <label>Malejąco: <input type="radio" name="sortorder" value="desc"<?php echo $order === 'desc' ? 'checked' : ''; ?>></label>
        </div>
        <div>
          <div>Rozmiar Paczki</div>
          <label>1<input type="radio" name="size" value="1"<?php echo $size == 1 ? 'checked' : ''; ?>></label>
          <label>5<input type="radio" name="size" value="5"<?php echo $size == 5 ? 'checked' : ''; ?>></label>
          <label>10<input type="radio" name="size" value="10"<?php echo $size == 10 ? 'checked' : ''; ?>></label>
          <label>25<input type="radio" name="size" value="25"<?php echo $size == 25 ? 'checked' : ''; ?>></label>
        </div>
        <input type="submit" value="sortuj">
      </form>
    </div>

    <div class="tbl-header">
      <table cellpadding="0" cellspacing="0" border="0">
        <thead>
          <tr>
            <th>Id</th>
            <th>Tytuł</th>
            <th>Data</th>
            <th>Opcje</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="tbl-content">
      <table cellpadding="0" cellspacing="0" border="0">
        <tbody>
            <?php foreach($params['notes'] ?? [] as $note): ?>
              <tr>
                <td>
                  <?php echo $note['id']?>
                </td>
                <td>
                  <?php echo $note['title']?>
                </td>
                <td>
                  <?php echo $note['created']?>
                </td>
                <td>
                 <a href="/?action=show&id=<?php echo $note['id']; ?>"><button>Szczegóły</button></a>
                 <a href="/?action=delete&id=<?php echo $note['id']; ?>"><button>Usuń</button></a>
                </td>
              </tr>
            <?php endforeach;?>
        </tbody>
      </table>

      <?php $paginationUrl = "&sortbyy=$by&sortorder=$order&size=$size&phrase=$phrase"?>
      <ul class="pagination">
          <?php if(!($number == 1)): ?>
            <li>
              <a href="/?page=<?php echo $number-1 . $paginationUrl1?>">
                <button>
                  <?php echo "<<"; ?>
                </button>
              </a>
            </li>
          <?php endif; ?>
        <?php for($i = 1; $i <= $pages; $i++): ?>
          <li>
            <a href="/?page=<?php echo $i . $paginationUrl?>">
              <button>
                <?php echo $i; ?>
              </button>
            </a>
          </li>
        <?php endfor; ?>
          <?php if($number < $pages): ?>
            <li>
              <a href="/?page=<?php echo $number+1 . $paginationUrl?>">
                <button>
                  <?php echo ">>"; ?>
                </button>
              </a>
            </li>
          <?php endif; ?>
        </ul>
    </section>
  </div>