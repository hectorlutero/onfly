<?php

namespace App\Services;

use App\DTO\StoreExpenseDTO;
use App\DTO\UpdateExpenseDTO;
use App\Models\Expense;
use App\Repositories\Contracts\ExpenseRepositoryInterface;
use Illuminate\Http\Request;
use stdClass;

class ExpenseService
{
    public function __construct(
        protected ExpenseRepositoryInterface $expenseRepository,
    ) {
    }

    public function paginate(int $page = 1, int $totalPerPage = 10, string $filter = null): array
    {
        return [];
    }
    public function getAll(string $filter = null): array
    {
        $expenses = $this->expenseRepository->getAll($filter);
        return $expenses;
    }

    public function getById(int $id): Expense | null
    {
        $expense = $this->expenseRepository->getById($id);
        return $expense ? (object) $expense : null;
    }

    public function create(StoreExpenseDTO $dto): Expense
    {
        $dto->date = \Carbon\Carbon::createFromFormat('d/m/Y', $dto->date)->format('Y-m-d');
        $expense = $this->expenseRepository->create($dto);
        return (object) $expense;
    }

    public function update($data, int $id): Expense
    {
        if (isset($data->date))
            $data->date = \Carbon\Carbon::createFromFormat('d/m/Y', $data->date)->format('Y-m-d');
        $expense = $this->expenseRepository->update($data, $id);
        return (object) $expense;
    }

    public function delete(int $id): bool
    {
        return $this->expenseRepository->delete($id);
    }
}
