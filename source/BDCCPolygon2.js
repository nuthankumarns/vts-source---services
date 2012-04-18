/*! 
    * KMPolyline - Draw solid or dashed polylines. 
  * 
  * Extended Google's GPolyline class. 
  * 
 * Rewritten Bill Chadwick's BDCCPolyline.js script. 
  * http://www.bdcc.co.uk/Gmaps/BdccGmapBits.htm 
 * 
 * Non-solid polylines only if drawing is performed using VML or SVG. 
 * 
  * Prototype.js v1.6+ required - http://prototypejs.org/ 
  * 
 * Downloaded from: Martin Milesich - http://milesich.com/ 
  * 
 * Free for any use. 
  */  
  
var KMPolylineCounter = 0;  
   
 // Constructor  
 function KMPolyline(points, color, weight, opacity, tooltip, dash)  
 {  
     ++KMPolylineCounter;  
  
     this.points    = points  || [];  
    this.color     = color   || "#000000";  
    this.weight    = weight  || 1;  
     this.tooltip   = tooltip || "";  
     this.dash      = dash    || "solid";  
     this.elemId    = "KMPolylineId" + KMPolylineCounter.toString();  
     this.opacity   = Math.abs(opacity - (KMPolylineCounter + 1) / 10000);  
   this.usesVml   = Prototype.Browser.IE;  

     GPolyline.call(this, this.points, this.color, this.weight, this.opacity, {"clickable": false}); //call parent constructor  
 }  
   
 KMPolyline.prototype = new GPolyline([new GLatLng(0,0)]);  
   
 KMPolyline.prototype.copy = function()  
 {  
     return new KMPolyline(this.points, this.color, this.weight, this.opacity, this.tooltip, this.dash);  
 }  
   
KMPolyline.prototype.redraw = function(force)  
 {  
   GPolyline.prototype.redraw.call(this, force); //call parent  
  
    var elem = null;  
   
    if (this.usesVml) {  
    // VML  
       var shps = $$('shape');  
  
       for (i = 0; i < shps.length; i++) {  
            if (shps[i].stroke.opacity.toFixed(4) == this.opacity) {  
               elem = shps[i];  
              break;  
           }  
        }  
    } else {  
    // SVG  
       elem = $$('path[stroke-opacity="'+this.opacity+'"]').first();  
  
        if (elem != null) {  
            Element.writeAttribute(elem, "pointer-events", "stroke");  
       }  
   }  
  
   if (elem != null) {  
      if (this.tooltip != "") {  
            elem.style.cursor = "help";  
           Element.writeAttribute(elem, 'title', this.tooltip);  
       }  
  
    Element.writeAttribute(elem, 'id', this.elemId);  
  
       this.setDash(this.dash);  
  
       var eClick = GEvent.callback(this, this.onClick);  
      var eOver  = GEvent.callback(this, this.onOver);  
       var eOut   = GEvent.callback(this, this.onOut);  
  
        GEvent.clearInstanceListeners(elem);  
 
      GEvent.addDomListener(elem, "click",     function() {eClick()});  
       GEvent.addDomListener(elem, "mouseover", function() {eOver()});  
      GEvent.addDomListener(elem, "mouseout",  function() {eOut()});  
  }  
}  
   
 // event handlers  
 KMPolyline.prototype.onClick = function() {GEvent.trigger(this, "click")}  
 KMPolyline.prototype.onOver  = function() {GEvent.trigger(this, "mouseover")}  
 KMPolyline.prototype.onOut   = function() {GEvent.trigger(this, "mouseout")}  
   
 // getX functions  
 KMPolyline.prototype.getDash   = function() {return this.dash}  
 KMPolyline.prototype.getWeight = function() {return this.weight}  
 KMPolyline.prototype.getColor  = function() {return this.color}  
   
 // setX functions  
 KMPolyline.prototype.setDash = function(dash)  
 {  
    this.dash = dash;  
   
     var elem = $(this.elemId);  
   
     if (!elem) return;  
   
     if (this.usesVml) {  
         switch (this.dash) {  
             case "dash" : elem.stroke.dashstyle = "dash";  
                 break;  
             case "dot"  : elem.stroke.dashstyle = "dot";  
                break;  
            default     : elem.stroke.dashstyle = "";  
         }  
     } else {  
         switch (this.dash) {  
            case "dash" : Element.writeAttribute(elem, "stroke-dasharray", "10,10");  
                 break;  
             case "dot"  : Element.writeAttribute(elem, "stroke-dasharray", "3,17");  
                break;  
             default     : Element.writeAttribute(elem, "stroke-dasharray", null); // remove attribute  
        }  
     }  
 }  
   
 KMPolyline.prototype.setWeight = function(weight)  
{  
     this.weight = weight;  
   
     var elem = $(this.elemId);  
   
     if (!elem) return;  
  
    if (this.usesVml) {  
         elem.stroke.weight = this.weight.toString() + "px";  
    } else {  
         Element.writeAttribute(elem, "stroke-width", this.weight.toString() + "px");  
     }  
 }  
   
 KMPolyline.prototype.setColor = function(color)  
 {  
     this.color = color;  
   
     var elem = $(this.elemId);  
  
     if (!elem) return;  
   
     if (this.usesVml) {  
         elem.stroke.color = this.color;  
    } else {  
         Element.writeAttribute(elem, "stroke", this.color);  
     }  
 }  


