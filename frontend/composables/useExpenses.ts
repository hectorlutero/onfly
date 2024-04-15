import type { Expenses } from "~/types/Expenses";

export async function getAllExpenses() {
  try {
    const response = await fetch("/api/expenses");
    return response.json();
  } catch (error) {
    console.log(error);
  }
}

export async function getExpense(id: number) {
  try {
    const response = await fetch(`/api/expenses/${id}`);
    return response.json();
  } catch (error) {
    console.log(error);
  }
}

export async function createExpense(expense: Expenses) {
  try {
    const response = await fetch("/api/expenses", {
      method: "POST",
      body: JSON.stringify(expense),
    });
    return response.json();
  } catch (error) {
    console.log(error);
  }
}

export async function updateExpense(expense: Expenses) {
  try {
    const response = await fetch(`/api/expenses/${expense.id}`, {
      method: "PUT",
      body: JSON.stringify(expense),
    });
    return response.json();
  } catch (error) {
    console.log(error);
  }
}

export async function deleteExpense(id: number) {
  try {
    const response = await fetch(`/api/expenses/${id}`, {
      method: "DELETE",
    });
    return response.json();
  } catch (error) {
    console.log(error);
  }
}
