<?php
namespace App\Repositories;

use Illuminate\Http\Request;

    interface StaffRepositoryInterface
    {
        public function all();

        public function create($data);

        public function update($id, $data);

        public function delete($id);

        public function getAllStaffs();

        public function findStaff($id);

        public function createStaff(array $data);

        public function updateStaff(Request $request, $id);

        public function deleteStaff($id);
    }

