import { Controller } from 'stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        document.querySelector('[data-bs-toggle="offcanvas"]').addEventListener('click', function () {
            document.querySelector('.offcanvas-collapse').classList.toggle('open')
        })
    }
}
