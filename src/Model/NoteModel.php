<?php

declare(strict_types=1);


namespace App\Model;

use App\Exception\StorageException;
use App\Exception\NotFoundException;
use PDO;
use Throwable;

class NoteModel extends AbstractModel
{

  public function getNote(int $id) :array
  {
    try {
      $query = "SELECT * FROM notes WHERE id=$id";
      $result = $this->conn->query($query);
      $note = $result->fetch(PDO::FETCH_ASSOC);
      

    } catch(Throwable $e) {
      throw new StorageException("Nie udało się wczytać notatki.", 400, $e);
    } 
    if(!$note) {
      throw new NotFoundException("Notatka o id: $id nie została znaleziona");
    }
    return $note;
  }

  public function searchNotes(string $phraseType, string $phrase, int $pageNumber, int $pageSize,string $sortBy, $sortOrder): array
  {
    try{

      $limit = $pageSize;
      $offset = ($pageNumber -1) * $pageSize;

      if(!$sortBy === 'title' || !$sortBy === 'created')
      {
        $sortBy = 'title';
      }
      if(!$sortOrder === 'desc' || !$sortOrder === 'asc')
      {
        $sortOrder = 'asc';
      }

      $phrase = $this->conn->quote("%" . $phrase . "%", PDO::PARAM_STR);
      if($phraseType === 'title') {
        $query = "SELECT id, title, created FROM notes WHERE title LIKE ($phrase) ORDER BY $sortBy $sortOrder LIMIT $offset, $limit";
      } else {
        $query = "SELECT id, title, created FROM notes WHERE created LIKE ($phrase) ORDER BY $sortBy $sortOrder LIMIT $offset, $limit";
      }
      
      $result = $this->conn->query($query, PDO::FETCH_ASSOC);
      return $result->fetchAll(PDO::FETCH_ASSOC);
    } catch(Throwable $e) {
      throw new StorageException("Nie udało się wyszukać notatek");
    }
  }
  public function getSearchCount(string $phrase): int
  {
    try{
      $phrase = $this->conn->quote("%" . $phrase . "%", PDO::PARAM_STR);
      $query = "SELECT count(*) AS cn FROM notes WHERE title LIKE ($phrase)";
      $result = $this->conn->query($query, PDO::FETCH_ASSOC);
      $result = $result->fetch(PDO::FETCH_ASSOC);

      if($result == false) {
        throw new StorageException("Nie udało się pobrać informacji o liczbie notatek w bazie.");
      } else {
        return $result['cn'];
      }
    } catch(Throwable $e) {
      throw new StorageException("Nie udało się pobrać informacji o liczbie notatek w bazie.");
    }
  }

  public function getNotes(int $pageNumber, int $pageSize,string $sortBy, $sortOrder) :array
  {
      try{

        $limit = $pageSize;
        $offset = ($pageNumber -1) * $pageSize;

        if(!$sortBy === 'title' || !$sortBy === 'created')
        {
          $sortBy = 'title';
        }
        if(!$sortOrder === 'desc' || !$sortOrder === 'asc')
        {
          $sortOrder = 'asc';
        }

        $query = "SELECT id, title, created FROM notes ORDER BY $sortBy $sortOrder LIMIT $offset, $limit";
        $result = $this->conn->query($query, PDO::FETCH_ASSOC);
        return $result->fetchAll(PDO::FETCH_ASSOC);
      } catch(Throwable $e) {
        throw new StorageException("Nie udało się pobrać danych z bazy.");
      }

  }
  public function getCount() :int
  {
    try{
      $query = "SELECT count(*) AS cn FROM notes";
      $result = $this->conn->query($query, PDO::FETCH_ASSOC);
      $result = $result->fetch(PDO::FETCH_ASSOC);

      if($result == false) {
        throw new StorageException("Nie udało się pobrać informacji o liczbie notatek w bazie.");
      } else {
        return $result['cn'];
      }
    } catch(Throwable $e) {
      throw new StorageException("Nie udało się pobrać informacji o liczbie notatek w bazie.");
    }

  }
  public function createNote(array $data): void
  {
    try {
      $title = $this->conn->quote($data['title']);
      $description = $this->conn->quote($data['description']);
      $created = $this->conn->quote(date('Y-m-d H:i:s'));

      $query = "
        INSERT INTO notes(title, description, created)
        VALUES($title, $description, $created)
      ";

      $this->conn->exec($query);
    } catch (Throwable $e) {
      throw new StorageException('Nie udało się utworzyć nowej notatki', 400, $e);
    }
  }
  public function editNote(int $id, array $data):void
  {
    try {
      $title = $this->conn->quote($data['title']);
      $description = $this->conn->quote($data['description']);

      $query = "
        UPDATE notes
        SET title = $title, description = $description
        WHERE id = $id
      ";

      $this->conn->exec($query);
    } catch(Throwable $e) {
      throw new StorageException("Nie udało się zaktualizować notatki", 400, $e);
    }
  }

  public function deleteNote(int $id) :void 
  {
    try {
      $query = "DELETE FROM notes WHERE id=$id";    
      $this->conn->exec($query);  

    } catch(Throwable $e) {
      throw new StorageException("Nie udało się usunąć notatki", 400, $e);
    }
  }


}
