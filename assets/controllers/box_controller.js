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
  static targets = [ "list" ];

  addRecall()
  {
    const collectionHolder = this.listTarget;
    
    const item = document.createElement('div');
    
    item.innerHTML = collectionHolder.dataset.prototype.replace(/__name__/g,collectionHolder.dataset.index);
    
    collectionHolder.append(item);
    
    collectionHolder.dataset.index++;
  }
}

/*
    document.querySelectorAll('.add_item_link').forEach(btn => {
      console.log("a");
      btn.addEventListener("click", addFormToCollection)
  });
  const addFormToCollection = (e) => {
  const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

  const item = document.createElement('li');

  item.innerHTML = collectionHolder.dataset.prototype.replace(/__name__/g,collectionHolder.dataset.index);

  collectionHolder.appendChild(item);

  collectionHolder.dataset.index++;
    };*/