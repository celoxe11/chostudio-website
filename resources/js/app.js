import "./bootstrap"; // import bootstrap js

// import jquery
import $ from "jquery";
window.$ = window.jQuery = $; // Make sure jQuery is available globally

// import sweetalert2
import Swal from "sweetalert2";
window.Swal = Swal; // Make SweetAlert2 available globally

// import notie
import notie from "notie";
import "notie/dist/notie.min.css"; // import notie styles
window.notie = notie; // Make notie available globally

// import vue-toastification
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css"; // import the styles
window.Toast = Toast; // Make Toast available globally
