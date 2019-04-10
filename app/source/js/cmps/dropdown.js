export default class Dropdown {
    el = null;
    active = false;
    data = [];
    close() {
        this.active = false
    }
    open() {
        this.active = true
    }
}