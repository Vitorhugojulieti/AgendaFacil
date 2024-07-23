import previewImage from "./modules/previewImage.js";
import ValidateCadService from "./modules/validateCadService.js";

const cadServiceValidator = new ValidateCadService('#formCadService');
cadServiceValidator.init();

const previewImage1 = new previewImage('#previewImage1','#inputImage1');
previewImage1.init();

const previewImage2 = new previewImage('#previewImage2','#inputImage2');
previewImage2.init();

const previewImage3 = new previewImage('#previewImage3','#inputImage3');
previewImage3.init();

