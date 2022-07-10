<?php

declare(strict_types=1);

namespace App\Controller;

class NoteController extends AbstractController
{
  private const PAGE_SIZE = "10";

  protected function createAction()
  {
    if ($this->request->hasPost()) {
      $noteData = [
        'title' => $this->request->postParam('title'),
        'description' => $this->request->postParam('description')
      ];
      $this->noteModel->createNote($noteData);
      $this->redirect("/", ['before' => 'created']);
    }
    $this->view->render('create');


  }
  protected function showAction()
  {
    $this->view->render(
      'show',
      ['note' => $this->getNote()]
  );
  }
  protected function listAction()
  { 
    $phraseType = $this->request->getParam('phraseType', 'title');
    $phrase = $this->request->getParam('phrase');
    $pageNumber = (int) $this->request->getParam('page', 1);
    $pageSize = (int) $this->request->getParam('size', self::PAGE_SIZE);
    $sortBy = $this->request->getParam('sortby', 'title');
    $sortOrder = $this->request->getParam('sortorder', 'asc');

    if($phrase) {
      $note = $this->noteModel->searchNotes($phraseType, $phrase, $pageNumber, $pageSize, $sortBy, $sortOrder);
      $count = $this->noteModel->getSearchCount($phrase);
    } else {
      $note = $this->noteModel->getNotes($pageNumber, $pageSize, $sortBy, $sortOrder);
      $count = $this->noteModel->getCount();
    }

        $viewParams = [
          'page' => ['number' => $pageNumber, 'size' => $pageSize, 'pages' =>(int) ceil($count/$pageSize)],
          'sort' => ['by' => $sortBy, 'order' => $sortOrder],
          'phrase' => $phrase,
          'phraseType' => $phraseType,
          'notes' => $note,
          'before' => $this->request->getParam('before'),
          'error' => $this->request->getParam('error'),
        ];
    $this->view->render('list', $viewParams ?? []);
  }
  protected function editAction()
  {
    if($this->request->isPost()) {
      $noteId = (int) $this->request->postParam('id');
      $noteData = [
        'title' => $this->request->postParam('title'),
        'description' => $this->request->postParam('description')
      ];
      $this->noteModel->editNote($noteId, $noteData);
      $this->redirect('/', ['before' => 'edited']);
    }

    $this->view->render(
      'edit',
      ['note' => $this->getNote()]
  );
  }

  public function deleteAction(): void
  {
    if($this->request->isPost()) {
      $id = (int) $this->request->postParam('id');
      $this->noteModel->deleteNote($id);
      $this->redirect('/', ['before' => 'deleted']);
    }

    $note = $this->getNote();
    $this->view->render(
      'delete',
      ['note' => $this->getNote()]
  );

  }
  public function getNote(): array
  {
    $noteId = (int) $this->request->getParam('id');

    if(!$noteId) {
      $this->redirect("/", ['error' => 'missingNoteId']);
    }

      return $this->noteModel->getNote($noteId);


  }
}
