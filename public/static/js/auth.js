// async позволяет использовать await
let auth_form = document.forms.auth;
console.log("AUTH");
auth_form.addEventListener("submit", async (event) => {
  event.preventDefault();
  try {
    // await заставляет ждать, пока код функции (промиса)
    // после него (в данном случае fetch) не выполнится
    const response = await fetch("/login", {
      method: "POST", // PUT
      body: new FormData(auth_form),
    });
    const answer = await response.text(); // .json();
    console.log("ответ сервера " + answer);
    responseHandler(answer);
  } catch (error) {
    console.log("ошибка", error);
  }
});
const AUTCH_ERROR='Ошибка авторизации';
const AUTH_OK='Авторизацуия прошла успешно';
function responseHandler(answer){
    if(answer===AUTCH_ERROR){
      alert(answer);
    } else if(answer===AUTH_OK){
      window.location.replace('/account');
    }
}
