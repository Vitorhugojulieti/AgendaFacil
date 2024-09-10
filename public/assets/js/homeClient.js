import formValidate from "./modules/formValidate.js";
import maskInput from "./modules/masksInput.js";

const formValidator = new formValidate();
const form = document.querySelector('#formLocation');
const spanError = document.querySelector('#spanErrorCep');
const inputCep = document.querySelector('#inputLocation');
const iconError = "<i class='bx bxs-info-circle' style='color:#fd837c'  ></i>";
const viewLocation = document.querySelector('#viewLocation');
const btnCloseModal = document.querySelector('#btnCloseModalLocation');
const btnOpenModal = document.querySelector('#btnOpenModalLocation');

const maskInputCep = new maskInput(null,null,'#inputLocation');
maskInputCep.init();

