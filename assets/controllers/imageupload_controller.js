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
        const $placeholder = document.querySelector(this.element.dataset.relatedImg);
        $placeholder.addEventListener('click', function() {
            this.element.click();
        }.bind(this));
        this.element.addEventListener('change', function(event) {
            var reader = new FileReader();
            reader.onload = function(){
            var output = $placeholder;
            output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        })
    }
}