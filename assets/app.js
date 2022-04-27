/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

//Стили формы регистарции
import './styles/RegistrationForm/main.css';

//Стили формы входа
import './styles/LoginForm/main.css';

//Стили формы добавления новости
import './styles/LoadNewForm/main.css';

//Стили формы добавления комментария
import './styles/LoadCommentForm/main.css';

// start the Stimulus application
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle';

var form = document.querySelector('form');

// var formReset = function(form){
//     form.reset()
//     console.log("sdbd")
// }
// function AddNewsHandler() {

//     $.ajax({
//         type: "POST",
//         url: "/AddNews",
//         dataType: 'json',
//         data: $("form").serialize(),
//         cache: false,
//         success: function(html) { 
//         console.log(html.status) 
//         }
//     });
//     return false;
// };

// var loadButton = document.querySelector('.load');

// loadButton.addEventListener('click', AddNewsHandler)

// var error = document.querySelector('.error');
// error.innerHTML = " ";

// ----Очистка формы при закрытии-----
var form_register = document.querySelector('.form--register');
var form_login = document.querySelector('.LoginForm--content');

var close_registrationForm_btn  = document.querySelector('.close--registrationForm');
var close_LoginForm_btn  = document.querySelector('.close--LoginForm');

close_registrationForm_btn.addEventListener('click', () => {form_register.reset()})
close_LoginForm_btn.addEventListener('click', () => {
    form_login.email.value = " ";
    form_login.password.value = "";
})
// form_register.reset()
// form_login.email.value = " ";
// form_login.password.value = "";

var p
const post = document.querySelectorAll('.post');
var posts = document.querySelector('.posts');
for (var i = 0; i < post.length; i++) {
    p += posts.childNodes[i*2 + 1].innerHTML
}
//console.log(p)

// Задаем элемент для наблюдения
let el = document.querySelector('.element');
// Прикрепляем его к «наблюдателю»
observer.observe(el);

var flag = 0;
// Создаем новый observer (наблюдатель)
let observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
// Выводим в консоль сам элемент
        console.log(entry.target);
// Выводим в консоль true (если элемент виден) или false (если нет)
        if(entry.isIntersecting && flag == 0){
            console.log("Loading")
            flag ++;
            for (var i = post.length - 1; i >= 0; i--) {
                post[i].classList.remove('animate__animated')
            }
            window.setTimeout(function() {
                posts.innerHTML += p;
            }, 100)
            
        }
    });
});
