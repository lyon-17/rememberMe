import { Controller } from '@hotwired/stimulus';

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
  static targets = [ "list","name" ]

  add() {
    var name = this.nameTarget.value;
    const element = this.listTarget;
    if(name == '')
    {
      name = 'new recall';
    }
    var p = document.createElement('p');
    p.innerText = name;
    element.append(p);
  }
}