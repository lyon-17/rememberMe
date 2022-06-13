import { Controller } from '@hotwired/stimulus';

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