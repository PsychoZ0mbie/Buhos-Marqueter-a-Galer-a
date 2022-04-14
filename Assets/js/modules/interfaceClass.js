'use strict';

export default class Interface {
    constructor(){
        if(this.constructor == Interface){
            throw new Error("The abstract classes can't be instantiated");
        }
    }
    interface(){
        throw new Error("The method interface() must be implemented");
    }
    addItem(){
        throw new Error("The method addItem() must be implemented");
    }
    showItems(){
        throw new Error("The method addItem() must be implemented");
    }
    deleteItem(){
        throw new Error("The method deleteItem() must be implemented");
    }
    editItem(){
        throw new Error("The method editItem() must be implemented");
    }
    viewItem(){
        throw new Error("The method viewItem() must be implemented");
    }
}