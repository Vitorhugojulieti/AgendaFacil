import validateOtp from "./modules/validateOtp.js";
import enabledElementForTime from "./modules/enabledElementForTime.js";

const otpValidate = new validateOtp(".otp-input");
otpValidate.init();

const enabledElementTimer = new enabledElementForTime("#resendEmailBtn");

document.addEventListener('DOMContentLoaded',()=> {
    enabledElementTimer.init();
});
