import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static targets = [ "list","done","showButton" ];

  addRecall()
  {
    const collectionHolder = this.listTarget;
    
    var item = document.createElement("div");
    //__name__ is the placeholder when data-controller happens, replaced by the collection name+index
    item.innerHTML = collectionHolder.dataset.prototype.replace(/__name__/g,collectionHolder.dataset.index);
    item.setAttribute('class','new_recall');
    collectionHolder.append(item);
    
    collectionHolder.dataset.index++;
  }
  show() {
    const element = this.doneTargets;
    const button = this.showButtonTarget;
      element.forEach(element => {
        element.setAttribute('class','rec_done_show');
      });
      button.setAttribute('style','display:none');
    }

}