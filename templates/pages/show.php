<div class="show">
<?php $note = $params['note'] ?? null;
if($note):?>
    <ul>
        <li>Id: <?php echo htmlentities($note['id']); ?></li>
        <li>Tytuł: <?php echo htmlentities($note['title']); ?></li>
        <li><?php echo htmlentities($note['description']); ?></li>
        <li>Zapisano: <?php echo htmlentities($note['created']); ?></li>
    </ul>
    <a href="/"><button>Powrót do naszej listy notatek</button></a>
    <a href="/?action=edit&id=<?php echo $note['id']; ?>"><button>Edytuj</button></a>
<?php endif;?>
</div>