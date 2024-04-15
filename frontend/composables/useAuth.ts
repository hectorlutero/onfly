import { ofetch } from "ofetch";
const config = useRuntimeConfig();
const api = config.public.baseUrl;
const headers = {
  "Content-Type": "application/json",
  Accept: "application/json",
  Authorization: localStorage.getItem("token")
    ? `Bearer ${localStorage.getItem("token")}`
    : "",
};

export async function getCSRFToken() {
  try {
    const response = await fetch(`http://localhost/sanctum/csrf-cookie`, {
      method: "GET",
    });
  } catch (error) {
    console.log(error);
  }
}

export async function loginUser(email: string, password: string) {
  try {
    // getCSRFToken();
    const response = await ofetch(`${api}/login`, {
      method: "POST",
      body: JSON.stringify({ email, password }),
    });

    const token = response.token;

    localStorage.setItem("token", token);

    return navigateTo("/dashboard");
  } catch (error) {
    console.log(error);
  }
}

export async function logoutUser() {
  try {
    const response = await ofetch(`${api}/logout`, {
      method: "POST",
      headers: headers,
    });
    localStorage.removeItem("token");
    return navigateTo("/login");
  } catch (error) {
    console.log(error);
  }
}

export async function registerUser(
  name: string,
  email: string,
  password: string
) {
  try {
    const response = await ofetch(`${api}/api/register`, {
      method: "POST",
      body: JSON.stringify({ name, email, password }),
    });
    return response;
  } catch (error) {
    console.log(error);
  }
}

export async function getUser() {
  try {
    const response = await ofetch(`${api}/profile`, {
      method: "GET",
      headers: {
        Authorization: localStorage.getItem("token")
          ? `Bearer ${localStorage.getItem("token")}`
          : "",
      },
    });
    return response;
  } catch (error) {
    console.log(error);
  }
}
