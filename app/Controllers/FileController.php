<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\CSRF;
use App\Models\ProjectFile;
use App\Models\Project;
use App\Core\Auth;

class FileController extends Controller
{
    private $projectFileModel;
    private $projectModel;

    public function __construct()
    {
        $this->protect();
        $this->projectFileModel = $this->model('ProjectFile');
        $this->projectModel = $this->model('Project');
    }

    public function upload($projectId, Request $request)
    {
        Auth::check('manage_project_files');

        if ($request->isPost() && isset($_FILES['file'])) {
            $project = $this->projectModel->findByIdAndClientId($projectId, $_SESSION['client_id']);
            if (!$project) {
                die('Project not found or access denied.');
            }

            $file = $_FILES['file'];
            $uploadDir = 'uploads/projects/' . $projectId . '/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = basename($file['name']);
            $targetPath = $uploadDir . $fileName;
            $fileType = mime_content_type($file['tmp_name']);

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                $this->projectFileModel->create([
                    'project_id' => $projectId,
                    'user_id' => $_SESSION['user_id'],
                    'file_name' => $fileName,
                    'file_path' => $targetPath,
                    'file_type' => $fileType
                ]);
            }
        }
        $this->redirect('project/show/' . $projectId);
    }

    public function delete($fileId)
    {
        Auth::check('manage_project_files');

        $file = $this->projectFileModel->findById($fileId);
        if ($file) {
            $project = $this->projectModel->findByIdAndClientId($file->project_id, $_SESSION['client_id']);
            if ($project) {
                if (file_exists($file->file_path)) {
                    unlink($file->file_path);
                }
                $this->projectFileModel->delete($fileId);
                $this->redirect('project/show/' . $file->project_id);
                return;
            }
        }
        die('File not found or access denied.');
    }
}
