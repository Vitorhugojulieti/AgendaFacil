import previewImage from "./modules/previewImage.js";
import ValidateCadService from "./modules/validateCadService.js";

const cadServiceValidator = new ValidateCadService('#formCadService');
cadServiceValidator.init();

const previewImage1 = new previewImage('#previewImage1','#inputImage1','#iconImage1','#spanImage1','#msgInputImage1');
previewImage1.init();

const previewImage2 = new previewImage('#previewImage2','#inputImage2','#iconImage2','#spanImage2','#msgInputImage2');
previewImage2.init();

const previewImage3 = new previewImage('#previewImage3','#inputImage3','#iconImage3','#spanImage3','#msgInputImage3');
previewImage3.init();

