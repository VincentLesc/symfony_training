import { Controller } from 'stimulus';
const alertify = require('alertifyjs');

export default class extends Controller {
    connect() {
        alertify.set('notifier', 'position', 'top-right');
        if (this.element.dataset.type === 'success') {
            alertify.success(this.element.dataset.message);
        } else if(this.element.dataset.type === 'error') {
            alertify.error(this.element.dataset.message);
        } else {
            alertify.message(this.element.dataset.message, 0)
        }
    }
}
