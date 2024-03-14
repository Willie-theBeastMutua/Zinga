/*
 Highcharts JS v9.2.2 (2021-08-24)

 (c) 2016-2021 Highsoft AS
 Authors: Jon Arild Nygard

 License: www.highcharts.com/license
*/
'use strict';(function(a){"object"===typeof module&&module.exports?(a["default"]=a,module.exports=a):"function"===typeof define&&define.amd?define("highcharts/modules/sunburst",["highcharts"],function(n){a(n);a.Highcharts=n;return a}):a("undefined"!==typeof Highcharts?Highcharts:void 0)})(function(a){function n(a,c,e,x){a.hasOwnProperty(c)||(a[c]=x.apply(null,e))}a=a?a._modules:{};n(a,"Mixins/ColorMapSeries.js",[a["Core/Globals.js"],a["Core/Series/Point.js"],a["Core/Utilities.js"]],function(a,c,e){var r=
e.defined;e=e.addEvent;var q=a.noop;a=a.seriesTypes;e(c,"afterSetState",function(a){this.moveToTopOnHover&&this.graphic&&this.graphic.attr({zIndex:a&&"hover"===a.state?1:0})});return{colorMapPointMixin:{dataLabelOnNull:!0,moveToTopOnHover:!0,isValid:function(){return null!==this.value&&Infinity!==this.value&&-Infinity!==this.value}},colorMapSeriesMixin:{pointArrayMap:["value"],axisTypes:["xAxis","yAxis","colorAxis"],trackerGroups:["group","markerGroup","dataLabelsGroup"],getSymbol:q,parallelArrays:["x",
"y","value"],colorKey:"value",pointAttribs:a.column.prototype.pointAttribs,colorAttribs:function(a){var l={};!r(a.color)||a.state&&"normal"!==a.state||(l[this.colorProp||"fill"]=a.color);return l}}}});n(a,"Series/Treemap/TreemapAlgorithmGroup.js",[],function(){return function(){function a(a,e,r,q){this.height=a;this.width=e;this.plot=q;this.startDirection=this.direction=r;this.lH=this.nH=this.lW=this.nW=this.total=0;this.elArr=[];this.lP={total:0,lH:0,nH:0,lW:0,nW:0,nR:0,lR:0,aspectRatio:function(a,
e){return Math.max(a/e,e/a)}}}a.prototype.addElement=function(a){this.lP.total=this.elArr[this.elArr.length-1];this.total+=a;0===this.direction?(this.lW=this.nW,this.lP.lH=this.lP.total/this.lW,this.lP.lR=this.lP.aspectRatio(this.lW,this.lP.lH),this.nW=this.total/this.height,this.lP.nH=this.lP.total/this.nW,this.lP.nR=this.lP.aspectRatio(this.nW,this.lP.nH)):(this.lH=this.nH,this.lP.lW=this.lP.total/this.lH,this.lP.lR=this.lP.aspectRatio(this.lP.lW,this.lH),this.nH=this.total/this.width,this.lP.nW=
this.lP.total/this.nH,this.lP.nR=this.lP.aspectRatio(this.lP.nW,this.nH));this.elArr.push(a)};a.prototype.reset=function(){this.lW=this.nW=0;this.elArr=[];this.total=0};return a}()});n(a,"Mixins/DrawPoint.js",[],function(){var a=function(a){return"function"===typeof a},c=function(e){var c=this,q=e.animatableAttribs,l=e.onComplete,p=e.css,m=e.renderer,h=this.series&&this.series.chart.hasRendered?void 0:this.series&&this.series.options.animation,b=this.graphic;if(this.shouldDraw())b||(this.graphic=
b=m[e.shapeType](e.shapeArgs).add(e.group)),b.css(p).attr(e.attribs).animate(q,e.isNew?!1:h,l);else if(b){var d=function(){c.graphic=b=b&&b.destroy();a(l)&&l()};Object.keys(q).length?b.animate(q,void 0,function(){d()}):d()}};return{draw:c,drawPoint:function(a){(a.attribs=a.attribs||{})["class"]=this.getClassName();c.call(this,a)},isFn:a}});n(a,"Series/Treemap/TreemapPoint.js",[a["Mixins/DrawPoint.js"],a["Core/Series/SeriesRegistry.js"],a["Core/Utilities.js"]],function(a,c,e){var r=this&&this.__extends||
function(){var b=function(a,h){b=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(a,b){a.__proto__=b}||function(a,b){for(var d in b)b.hasOwnProperty(d)&&(a[d]=b[d])};return b(a,h)};return function(a,h){function d(){this.constructor=a}b(a,h);a.prototype=null===h?Object.create(h):(d.prototype=h.prototype,new d)}}(),q=c.series.prototype.pointClass,l=c.seriesTypes;c=l.pie.prototype.pointClass;var p=e.extend,m=e.isNumber,h=e.pick;e=function(a){function b(){var b=null!==a&&a.apply(this,arguments)||
this;b.name=void 0;b.node=void 0;b.options=void 0;b.series=void 0;b.value=void 0;return b}r(b,a);b.prototype.getClassName=function(){var b=q.prototype.getClassName.call(this),a=this.series,d=a.options;this.node.level<=a.nodeMap[a.rootNode].level?b+=" highcharts-above-level":this.node.isLeaf||h(d.interactByLeaf,!d.allowTraversingTree)?this.node.isLeaf||(b+=" highcharts-internal-node"):b+=" highcharts-internal-node-interactive";return b};b.prototype.isValid=function(){return!(!this.id&&!m(this.value))};
b.prototype.setState=function(b){q.prototype.setState.call(this,b);this.graphic&&this.graphic.attr({zIndex:"hover"===b?1:0})};b.prototype.shouldDraw=function(){return m(this.plotY)&&null!==this.y};return b}(l.scatter.prototype.pointClass);p(e.prototype,{draw:a.drawPoint,setVisible:c.prototype.setVisible});return e});n(a,"Series/Treemap/TreemapUtilities.js",[a["Core/Utilities.js"]],function(a){var c=a.objectEach,e;(function(a){function e(a,c,m){void 0===m&&(m=this);a=c.call(m,a);!1!==a&&e(a,c,m)}a.AXIS_MAX=
100;a.isBoolean=function(a){return"boolean"===typeof a};a.eachObject=function(a,e,m){m=m||this;c(a,function(h,b){e.call(m,h,b,a)})};a.recursive=e})(e||(e={}));return e});n(a,"Mixins/TreeSeries.js",[a["Core/Color/Color.js"],a["Core/Utilities.js"]],function(a,c){var e=c.extend,r=c.isArray,q=c.isNumber,l=c.isObject,p=c.merge,m=c.pick;return{getColor:function(h,b){var d=b.index,e=b.mapOptionsToLevel,c=b.parentColor,l=b.parentColorIndex,p=b.series,q=b.colors,r=b.siblings,w=p.points,E=p.chart.options.chart,
z;if(h){w=w[h.i];h=e[h.level]||{};if(e=w&&h.colorByPoint){var x=w.index%(q?q.length:E.colorCount);var n=q&&q[x]}if(!p.chart.styledMode){q=w&&w.options.color;E=h&&h.color;if(z=c)z=(z=h&&h.colorVariation)&&"brightness"===z.key?a.parse(c).brighten(d/r*z.to).get():c;z=m(q,E,n,z,p.color)}var G=m(w&&w.options.colorIndex,h&&h.colorIndex,x,l,b.colorIndex)}return{color:z,colorIndex:G}},getLevelOptions:function(a){var b=null;if(l(a)){b={};var d=q(a.from)?a.from:1;var c=a.levels;var h={};var m=l(a.defaults)?
a.defaults:{};r(c)&&(h=c.reduce(function(a,b){if(l(b)&&q(b.level)){var c=p({},b);var h="boolean"===typeof c.levelIsConstant?c.levelIsConstant:m.levelIsConstant;delete c.levelIsConstant;delete c.level;b=b.level+(h?0:d-1);l(a[b])?e(a[b],c):a[b]=c}return a},{}));c=q(a.to)?a.to:1;for(a=0;a<=c;a++)b[a]=p({},m,l(h[a])?h[a]:{})}return b},setTreeValues:function V(a,d){var b=d.before,c=d.idRoot,l=d.mapIdToNode[c],p=d.points[a.i],q=p&&p.options||{},w=0,r=[];a.levelDynamic=a.level-(("boolean"===typeof d.levelIsConstant?
d.levelIsConstant:1)?0:l.level);a.name=m(p&&p.name,"");a.visible=c===a.id||("boolean"===typeof d.visible?d.visible:!1);"function"===typeof b&&(a=b(a,d));a.children.forEach(function(b,c){var m=e({},d);e(m,{index:c,siblings:a.children.length,visible:a.visible});b=V(b,m);r.push(b);b.visible&&(w+=b.val)});b=m(q.value,w);a.visible=0<=b&&(0<w||a.visible);a.children=r;a.childrenTotal=w;a.isLeaf=a.visible&&!w;a.val=b;return a},updateRootId:function(a){if(l(a)){var b=l(a.options)?a.options:{};b=m(a.rootNode,
b.rootId,"");l(a.userOptions)&&(a.userOptions.rootId=b);a.rootNode=b}return b}}});n(a,"Series/Treemap/TreemapComposition.js",[a["Core/Series/SeriesRegistry.js"],a["Series/Treemap/TreemapUtilities.js"],a["Core/Utilities.js"]],function(a,c,e){var r=e.addEvent,q=e.extend,l=!1;r(a.series,"afterBindAxes",function(){var a=this.xAxis,e=this.yAxis;if(a&&e)if(this.is("treemap")){var h={endOnTick:!1,gridLineWidth:0,lineWidth:0,min:0,minPadding:0,max:c.AXIS_MAX,maxPadding:0,startOnTick:!1,title:void 0,tickPositions:[]};
q(e.options,h);q(a.options,h);l=!0}else l&&(e.setOptions(e.userOptions),a.setOptions(a.userOptions),l=!1)})});n(a,"Series/Treemap/TreemapSeries.js",[a["Core/Color/Color.js"],a["Mixins/ColorMapSeries.js"],a["Core/Globals.js"],a["Core/Legend/LegendSymbol.js"],a["Core/Color/Palette.js"],a["Core/Series/SeriesRegistry.js"],a["Series/Treemap/TreemapAlgorithmGroup.js"],a["Series/Treemap/TreemapPoint.js"],a["Series/Treemap/TreemapUtilities.js"],a["Mixins/TreeSeries.js"],a["Core/Utilities.js"]],function(a,
c,e,x,q,l,p,m,h,b,d){var r=this&&this.__extends||function(){var a=function(b,g){a=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(g,a){g.__proto__=a}||function(g,a){for(var k in a)a.hasOwnProperty(k)&&(g[k]=a[k])};return a(b,g)};return function(b,g){function k(){this.constructor=b}a(b,g);b.prototype=null===g?Object.create(g):(k.prototype=g.prototype,new k)}}(),Q=a.parse,n=c.colorMapSeriesMixin;a=e.noop;var A=l.series;c=l.seriesTypes;var M=c.column,N=c.heatmap,w=c.scatter,E=b.getColor,
z=b.getLevelOptions,L=b.updateRootId,H=d.addEvent,G=d.correctFloat,B=d.defined,O=d.error,K=d.extend,X=d.fireEvent,S=d.isArray,f=d.isObject,P=d.isString,C=d.merge,y=d.pick,Y=d.stableSort;b=function(a){function b(){var g=null!==a&&a.apply(this,arguments)||this;g.axisRatio=void 0;g.data=void 0;g.mapOptionsToLevel=void 0;g.nodeMap=void 0;g.options=void 0;g.points=void 0;g.rootNode=void 0;g.tree=void 0;return g}r(b,a);b.prototype.algorithmCalcPoints=function(g,a,b,f){var k,F,u,d,c=b.lW,e=b.lH,h=b.plot,
m=0,l=b.elArr.length-1;if(a)c=b.nW,e=b.nH;else var p=b.elArr[b.elArr.length-1];b.elArr.forEach(function(g){if(a||m<l)0===b.direction?(k=h.x,F=h.y,u=c,d=g/u):(k=h.x,F=h.y,d=e,u=g/d),f.push({x:k,y:F,width:u,height:G(d)}),0===b.direction?h.y+=d:h.x+=u;m+=1});b.reset();0===b.direction?b.width-=c:b.height-=e;h.y=h.parent.y+(h.parent.height-b.height);h.x=h.parent.x+(h.parent.width-b.width);g&&(b.direction=1-b.direction);a||b.addElement(p)};b.prototype.algorithmFill=function(g,a,b){var k=[],D,f=a.direction,
u=a.x,d=a.y,c=a.width,h=a.height,e,m,l,p;b.forEach(function(b){D=b.val/a.val*a.height*a.width;e=u;m=d;0===f?(p=h,l=D/p,c-=l,u+=l):(l=c,p=D/l,h-=p,d+=p);k.push({x:e,y:m,width:l,height:p});g&&(f=1-f)});return k};b.prototype.algorithmLowAspectRatio=function(a,b,f){var g=[],k=this,u,d={x:b.x,y:b.y,parent:b},c=0,h=f.length-1,e=new p(b.height,b.width,b.direction,d);f.forEach(function(f){u=f.val/b.val*b.height*b.width;e.addElement(u);e.lP.nR>e.lP.lR&&k.algorithmCalcPoints(a,!1,e,g,d);c===h&&k.algorithmCalcPoints(a,
!0,e,g,d);c+=1});return g};b.prototype.alignDataLabel=function(a,b,f){var g=f.style;g&&!B(g.textOverflow)&&b.text&&b.getBBox().width>b.text.textWidth&&b.css({textOverflow:"ellipsis",width:g.width+="px"});M.prototype.alignDataLabel.apply(this,arguments);a.dataLabel&&a.dataLabel.attr({zIndex:(a.node.zIndex||0)+1})};b.prototype.buildNode=function(a,b,f,d,D){var g=this,k=[],u=g.points[b],c=0,h;(d[a]||[]).forEach(function(b){h=g.buildNode(g.points[b].id,b,f+1,d,a);c=Math.max(h.height+1,c);k.push(h)});
b={id:a,i:b,children:k,height:c,level:f,parent:D,visible:!1};g.nodeMap[b.id]=b;u&&(u.node=b);return b};b.prototype.calculateChildrenAreas=function(a,b){var g=this,k=g.options,f=g.mapOptionsToLevel[a.level+1],d=y(g[f&&f.layoutAlgorithm]&&f.layoutAlgorithm,k.layoutAlgorithm),c=k.alternateStartingDirection,e=[];a=a.children.filter(function(a){return!a.ignore});f&&f.layoutStartingDirection&&(b.direction="vertical"===f.layoutStartingDirection?0:1);e=g[d](b,a);a.forEach(function(a,k){k=e[k];a.values=C(k,
{val:a.childrenTotal,direction:c?1-b.direction:b.direction});a.pointValues=C(k,{x:k.x/g.axisRatio,y:h.AXIS_MAX-k.y-k.height,width:k.width/g.axisRatio});a.children.length&&g.calculateChildrenAreas(a,a.values)})};b.prototype.drawDataLabels=function(){var a=this,b=a.mapOptionsToLevel,f,d;a.points.filter(function(a){return a.node.visible}).forEach(function(g){d=b[g.node.level];f={style:{}};g.node.isLeaf||(f.enabled=!1);d&&d.dataLabels&&(f=C(f,d.dataLabels),a._hasPointLabels=!0);g.shapeArgs&&(f.style.width=
g.shapeArgs.width,g.dataLabel&&g.dataLabel.css({width:g.shapeArgs.width+"px"}));g.dlOptions=C(f,g.options.dataLabels)});A.prototype.drawDataLabels.call(this)};b.prototype.drawPoints=function(){var a=this,b=a.chart,f=b.renderer,d=b.styledMode,c=a.options,h=d?{}:c.shadow,e=c.borderRadius,l=b.pointCount<c.animationLimit,m=c.allowTraversingTree;a.points.forEach(function(b){var g=b.node.levelDynamic,k={},u={},D={},F="level-group-"+b.node.level,T=!!b.graphic,p=l&&T,U=b.shapeArgs;b.shouldDraw()&&(b.isInside=
!0,e&&(u.r=e),C(!0,p?k:u,T?U:{},d?{}:a.pointAttribs(b,b.selected?"select":void 0)),a.colorAttribs&&d&&K(D,a.colorAttribs(b)),a[F]||(a[F]=f.g(F).attr({zIndex:1E3-(g||0)}).add(a.group),a[F].survive=!0));b.draw({animatableAttribs:k,attribs:u,css:D,group:a[F],renderer:f,shadow:h,shapeArgs:U,shapeType:"rect"});m&&b.graphic&&(b.drillId=c.interactByLeaf?a.drillToByLeaf(b):a.drillToByGroup(b))})};b.prototype.drillToByGroup=function(a){var b=!1;1!==a.node.level-this.nodeMap[this.rootNode].level||a.node.isLeaf||
(b=a.id);return b};b.prototype.drillToByLeaf=function(a){var b=!1;if(a.node.parent!==this.rootNode&&a.node.isLeaf)for(a=a.node;!b;)a=this.nodeMap[a.parent],a.parent===this.rootNode&&(b=a.id);return b};b.prototype.drillToNode=function(a,b){O(32,!1,void 0,{"treemap.drillToNode":"use treemap.setRootNode"});this.setRootNode(a,b)};b.prototype.drillUp=function(){var a=this.nodeMap[this.rootNode];a&&P(a.parent)&&this.setRootNode(a.parent,!0,{trigger:"traverseUpButton"})};b.prototype.getExtremes=function(){var a=
A.prototype.getExtremes.call(this,this.colorValueData),b=a.dataMax;this.valueMin=a.dataMin;this.valueMax=b;return A.prototype.getExtremes.call(this)};b.prototype.getListOfParents=function(a,b){a=S(a)?a:[];var g=S(b)?b:[];b=a.reduce(function(a,b,g){b=y(b.parent,"");"undefined"===typeof a[b]&&(a[b]=[]);a[b].push(g);return a},{"":[]});h.eachObject(b,function(a,b,f){""!==b&&-1===g.indexOf(b)&&(a.forEach(function(a){f[""].push(a)}),delete f[b])});return b};b.prototype.getTree=function(){var a=this.data.map(function(a){return a.id});
a=this.getListOfParents(this.data,a);this.nodeMap={};return this.buildNode("",-1,0,a)};b.prototype.hasData=function(){return!!this.processedXData.length};b.prototype.init=function(a,b){n&&(this.colorAttribs=n.colorAttribs);var g=H(this,"setOptions",function(a){a=a.userOptions;B(a.allowDrillToNode)&&!B(a.allowTraversingTree)&&(a.allowTraversingTree=a.allowDrillToNode,delete a.allowDrillToNode);B(a.drillUpButton)&&!B(a.traverseUpButton)&&(a.traverseUpButton=a.drillUpButton,delete a.drillUpButton)});
A.prototype.init.call(this,a,b);delete this.opacity;this.eventsToUnbind.push(g);this.options.allowTraversingTree&&this.eventsToUnbind.push(H(this,"click",this.onClickDrillToNode))};b.prototype.onClickDrillToNode=function(a){var b=(a=a.point)&&a.drillId;P(b)&&(a.setState(""),this.setRootNode(b,!0,{trigger:"click"}))};b.prototype.pointAttribs=function(a,b){var g=f(this.mapOptionsToLevel)?this.mapOptionsToLevel:{},k=a&&g[a.node.level]||{};g=this.options;var d=b&&g.states[b]||{},c=a&&a.getClassName()||
"";a={stroke:a&&a.borderColor||k.borderColor||d.borderColor||g.borderColor,"stroke-width":y(a&&a.borderWidth,k.borderWidth,d.borderWidth,g.borderWidth),dashstyle:a&&a.borderDashStyle||k.borderDashStyle||d.borderDashStyle||g.borderDashStyle,fill:a&&a.color||this.color};-1!==c.indexOf("highcharts-above-level")?(a.fill="none",a["stroke-width"]=0):-1!==c.indexOf("highcharts-internal-node-interactive")?(b=y(d.opacity,g.opacity),a.fill=Q(a.fill).setOpacity(b).get(),a.cursor="pointer"):-1!==c.indexOf("highcharts-internal-node")?
a.fill="none":b&&(a.fill=Q(a.fill).brighten(d.brightness).get());return a};b.prototype.renderTraverseUpButton=function(a){var b=this,g=b.options.traverseUpButton,f=y(g.text,b.nodeMap[a].name,"\u25c1 Back");if(""===a||b.is("sunburst")&&1===b.tree.children.length&&a===b.tree.children[0].id)b.drillUpButton&&(b.drillUpButton=b.drillUpButton.destroy());else if(this.drillUpButton)this.drillUpButton.placed=!1,this.drillUpButton.attr({text:f}).align();else{var d=(a=g.theme)&&a.states;this.drillUpButton=this.chart.renderer.button(f,
0,0,function(){b.drillUp()},a,d&&d.hover,d&&d.select).addClass("highcharts-drillup-button").attr({align:g.position.align,zIndex:7}).add().align(g.position,!1,g.relativeTo||"plotBox")}};b.prototype.setColorRecursive=function(a,b,f,d,c){var g=this,k=g&&g.chart;k=k&&k.options&&k.options.colors;if(a){var h=E(a,{colors:k,index:d,mapOptionsToLevel:g.mapOptionsToLevel,parentColor:b,parentColorIndex:f,series:g,siblings:c});if(b=g.points[a.i])b.color=h.color,b.colorIndex=h.colorIndex;(a.children||[]).forEach(function(b,
f){g.setColorRecursive(b,h.color,h.colorIndex,f,a.children.length)})}};b.prototype.setPointValues=function(){var a=this,b=a.xAxis,f=a.yAxis,d=a.chart.styledMode;a.points.forEach(function(g){var c=g.node,k=c.pointValues;c=c.visible;if(k&&c){c=k.height;var h=k.width,e=k.x,l=k.y,m=d?0:(a.pointAttribs(g)["stroke-width"]||0)%2/2;k=Math.round(b.toPixels(e,!0))-m;h=Math.round(b.toPixels(e+h,!0))-m;e=Math.round(f.toPixels(l,!0))-m;c=Math.round(f.toPixels(l+c,!0))-m;c={x:Math.min(k,h),y:Math.min(e,c),width:Math.abs(h-
k),height:Math.abs(c-e)};g.plotX=c.x+c.width/2;g.plotY=c.y+c.height/2;g.shapeArgs=c}else delete g.plotX,delete g.plotY})};b.prototype.setRootNode=function(a,b,f){a=K({newRootId:a,previousRootId:this.rootNode,redraw:y(b,!0),series:this},f);X(this,"setRootNode",a,function(a){var b=a.series;b.idPreviousRoot=a.previousRootId;b.rootNode=a.newRootId;b.isDirty=!0;a.redraw&&b.chart.redraw()})};b.prototype.setState=function(a){this.options.inactiveOtherPoints=!0;A.prototype.setState.call(this,a,!1);this.options.inactiveOtherPoints=
!1};b.prototype.setTreeValues=function(a){var b=this,g=b.options,f=b.nodeMap[b.rootNode];g=h.isBoolean(g.levelIsConstant)?g.levelIsConstant:!0;var d=0,c=[],e=b.points[a.i];a.children.forEach(function(a){a=b.setTreeValues(a);c.push(a);a.ignore||(d+=a.val)});Y(c,function(a,b){return(a.sortIndex||0)-(b.sortIndex||0)});var l=y(e&&e.options.value,d);e&&(e.value=l);K(a,{children:c,childrenTotal:d,ignore:!(y(e&&e.visible,!0)&&0<l),isLeaf:a.visible&&!d,levelDynamic:a.level-(g?0:f.level),name:y(e&&e.name,
""),sortIndex:y(e&&e.sortIndex,-l),val:l});return a};b.prototype.sliceAndDice=function(a,b){return this.algorithmFill(!0,a,b)};b.prototype.squarified=function(a,b){return this.algorithmLowAspectRatio(!0,a,b)};b.prototype.strip=function(a,b){return this.algorithmLowAspectRatio(!1,a,b)};b.prototype.stripes=function(a,b){return this.algorithmFill(!1,a,b)};b.prototype.translate=function(){var a=this,b=a.options,f=L(a);A.prototype.translate.call(a);var d=a.tree=a.getTree();var c=a.nodeMap[f];""===f||c&&
c.children.length||(a.setRootNode("",!1),f=a.rootNode,c=a.nodeMap[f]);a.renderTraverseUpButton(f);a.mapOptionsToLevel=z({from:c.level+1,levels:b.levels,to:d.height,defaults:{levelIsConstant:a.options.levelIsConstant,colorByPoint:b.colorByPoint}});h.recursive(a.nodeMap[a.rootNode],function(b){var f=!1,d=b.parent;b.visible=!0;if(d||""===d)f=a.nodeMap[d];return f});h.recursive(a.nodeMap[a.rootNode].children,function(a){var b=!1;a.forEach(function(a){a.visible=!0;a.children.length&&(b=(b||[]).concat(a.children))});
return b});a.setTreeValues(d);a.axisRatio=a.xAxis.len/a.yAxis.len;a.nodeMap[""].pointValues=f={x:0,y:0,width:h.AXIS_MAX,height:h.AXIS_MAX};a.nodeMap[""].values=f=C(f,{width:f.width*a.axisRatio,direction:"vertical"===b.layoutStartingDirection?0:1,val:d.val});a.calculateChildrenAreas(d,f);a.colorAxis||b.colorByPoint||a.setColorRecursive(a.tree);b.allowTraversingTree&&(b=c.pointValues,a.xAxis.setExtremes(b.x,b.x+b.width,!1),a.yAxis.setExtremes(b.y,b.y+b.height,!1),a.xAxis.setScale(),a.yAxis.setScale());
a.setPointValues()};b.defaultOptions=C(w.defaultOptions,{allowTraversingTree:!1,animationLimit:250,borderRadius:0,showInLegend:!1,marker:void 0,colorByPoint:!1,dataLabels:{defer:!1,enabled:!0,formatter:function(){var a=this&&this.point?this.point:{};return P(a.name)?a.name:""},inside:!0,verticalAlign:"middle"},tooltip:{headerFormat:"",pointFormat:"<b>{point.name}</b>: {point.value}<br/>"},ignoreHiddenPoint:!0,layoutAlgorithm:"sliceAndDice",layoutStartingDirection:"vertical",alternateStartingDirection:!1,
levelIsConstant:!0,drillUpButton:{position:{align:"right",x:-10,y:10}},traverseUpButton:{position:{align:"right",x:-10,y:10}},borderColor:q.neutralColor10,borderWidth:1,colorKey:"colorValue",opacity:.15,states:{hover:{borderColor:q.neutralColor40,brightness:N?0:.1,halo:!1,opacity:.75,shadow:!1}}});return b}(w);K(b.prototype,{buildKDTree:a,colorKey:"colorValue",directTouch:!0,drawLegendSymbol:x.drawRectangle,getExtremesFromAll:!0,getSymbol:a,optionalAxis:"colorAxis",parallelArrays:["x","y","value",
"colorValue"],pointArrayMap:["value"],pointClass:m,trackerGroups:["group","dataLabelsGroup"],utils:{recursive:h.recursive}});l.registerSeriesType("treemap",b);"";return b});n(a,"Series/Sunburst/SunburstPoint.js",[a["Core/Series/SeriesRegistry.js"],a["Core/Utilities.js"]],function(a,c){var e=this&&this.__extends||function(){var a=function(c,e){a=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(a,b){a.__proto__=b}||function(a,b){for(var d in b)b.hasOwnProperty(d)&&(a[d]=b[d])};return a(c,
e)};return function(c,e){function h(){this.constructor=c}a(c,e);c.prototype=null===e?Object.create(e):(h.prototype=e.prototype,new h)}}(),r=a.series.prototype.pointClass,q=c.correctFloat;c=c.extend;a=function(a){function c(){var c=null!==a&&a.apply(this,arguments)||this;c.node=void 0;c.options=void 0;c.series=void 0;c.shapeExisting=void 0;return c}e(c,a);c.prototype.getDataLabelPath=function(a){var c=this.series.chart.renderer,b=this.shapeExisting,d=b.start,e=b.end,l=d+(e-d)/2;l=0>l&&l>-Math.PI||
l>Math.PI;var m=b.r+(a.options.distance||0);d===-Math.PI/2&&q(e)===q(1.5*Math.PI)&&(d=-Math.PI+Math.PI/360,e=-Math.PI/360,l=!0);if(e-d>Math.PI){l=!1;var p=!0}this.dataLabelPath&&(this.dataLabelPath=this.dataLabelPath.destroy());this.dataLabelPath=c.arc({open:!0,longArc:p?1:0}).add(a);this.dataLabelPath.attr({start:l?d:e,end:l?e:d,clockwise:+l,x:b.x,y:b.y,r:(m+b.innerR)/2});return this.dataLabelPath};c.prototype.isValid=function(){return!0};c.prototype.shouldDraw=function(){return!this.isNull};return c}(a.seriesTypes.treemap.prototype.pointClass);
c(a.prototype,{getClassName:r.prototype.getClassName,haloPath:r.prototype.haloPath,setState:r.prototype.setState});return a});n(a,"Series/Sunburst/SunburstUtilities.js",[a["Core/Series/SeriesRegistry.js"],a["Core/Utilities.js"]],function(a,c){var e=a.seriesTypes.treemap,r=c.isNumber,q=c.isObject,l=c.merge,p;(function(a){function c(a,c){var b=[];if(r(a)&&r(c)&&a<=c)for(;a<=c;a++)b.push(a);return b}a.recursive=e.prototype.utils.recursive;a.calculateLevelSizes=function(a,d){d=q(d)?d:{};var b=0,e;if(q(a)){var h=
l({},a);a=r(d.from)?d.from:0;var m=r(d.to)?d.to:0;var p=c(a,m);a=Object.keys(h).filter(function(a){return-1===p.indexOf(+a)});var n=e=r(d.diffRadius)?d.diffRadius:0;p.forEach(function(a){a=h[a];var c=a.levelSize.unit,d=a.levelSize.value;"weight"===c?b+=d:"percentage"===c?(a.levelSize={unit:"pixels",value:d/100*n},e-=a.levelSize.value):"pixels"===c&&(e-=d)});p.forEach(function(a){var c=h[a];"weight"===c.levelSize.unit&&(c=c.levelSize.value,h[a].levelSize={unit:"pixels",value:c/b*e})});a.forEach(function(a){h[a].levelSize=
{value:0,unit:"pixels"}})}return h};a.getLevelFromAndTo=function(a){var b=a.level;return{from:0<b?b:1,to:b+a.height}};a.range=c})(p||(p={}));return p});n(a,"Series/Sunburst/SunburstSeries.js",[a["Mixins/CenteredSeries.js"],a["Core/Globals.js"],a["Core/Series/SeriesRegistry.js"],a["Series/Sunburst/SunburstPoint.js"],a["Series/Sunburst/SunburstUtilities.js"],a["Mixins/TreeSeries.js"],a["Core/Utilities.js"]],function(a,c,e,n,q,l,p){function m(a,b){var c=b.mapIdToNode[a.parent],d=b.series,e=d.chart,h=
d.points[a.i];c=A(a,{colors:d.options.colors||e&&e.options.colors,colorIndex:d.colorIndex,index:b.index,mapOptionsToLevel:b.mapOptionsToLevel,parentColor:c&&c.color,parentColorIndex:c&&c.colorIndex,series:b.series,siblings:b.siblings});a.color=c.color;a.colorIndex=c.colorIndex;h&&(h.color=a.color,h.colorIndex=a.colorIndex,a.sliced=a.id!==b.idRoot?h.sliced:!1);return a}var h=this&&this.__extends||function(){var a=function(b,c){a=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(a,b){a.__proto__=
b}||function(a,b){for(var c in b)b.hasOwnProperty(c)&&(a[c]=b[c])};return a(b,c)};return function(b,c){function f(){this.constructor=b}a(b,c);b.prototype=null===c?Object.create(c):(f.prototype=c.prototype,new f)}}(),b=a.getCenter,d=a.getStartAndEndRadians;a=c.noop;var r=e.series,x=e.seriesTypes;c=x.column;var R=x.treemap,A=l.getColor,M=l.getLevelOptions,N=l.setTreeValues,w=l.updateRootId,E=p.error,z=p.extend,L=p.isNumber,H=p.isObject,G=p.isString,B=p.merge,O=p.splat,K=180/Math.PI;l=function(a){function c(){var b=
null!==a&&a.apply(this,arguments)||this;b.center=void 0;b.data=void 0;b.mapOptionsToLevel=void 0;b.nodeMap=void 0;b.options=void 0;b.points=void 0;b.shapeRoot=void 0;b.startAndEndRadians=void 0;b.tree=void 0;return b}h(c,a);c.prototype.alignDataLabel=function(b,c,d){if(!d.textPath||!d.textPath.enabled)return a.prototype.alignDataLabel.apply(this,arguments)};c.prototype.animate=function(a){var b=this.chart,c=[b.plotWidth/2,b.plotHeight/2],d=b.plotLeft,f=b.plotTop;b=this.group;a?(a={translateX:c[0]+
d,translateY:c[1]+f,scaleX:.001,scaleY:.001,rotation:10,opacity:.01},b.attr(a)):(a={translateX:d,translateY:f,scaleX:1,scaleY:1,rotation:0,opacity:1},b.animate(a,this.options.animation))};c.prototype.drawPoints=function(){var a=this,b=a.mapOptionsToLevel,c=a.shapeRoot,d=a.group,e=a.hasRendered,h=a.rootNode,l=a.idPreviousRoot,g=a.nodeMap,k=g[l],p=k&&k.shapeArgs;k=a.points;var m=a.startAndEndRadians,q=a.chart,n=q&&q.options&&q.options.chart||{},w="boolean"===typeof n.animation?n.animation:!0,I=a.center[3]/
2,x=a.chart.renderer,A=!1,E=!1;if(n=!!(w&&e&&h!==l&&a.dataLabelsGroup)){a.dataLabelsGroup.attr({opacity:0});var G=function(){A=!0;a.dataLabelsGroup&&a.dataLabelsGroup.animate({opacity:1,visibility:"visible"})}}k.forEach(function(f){var k=f.node,t=b[k.level];var r=f.shapeExisting||{};var n=k.shapeArgs||{},u=!(!k.visible||!k.shapeArgs);if(e&&w){var J={};var C={end:n.end,start:n.start,innerR:n.innerR,r:n.r,x:n.x,y:n.y};u?!f.graphic&&p&&(J=h===f.id?{start:m.start,end:m.end}:p.end<=n.start?{start:m.end,
end:m.end}:{start:m.start,end:m.start},J.innerR=J.r=I):f.graphic&&(l===f.id?C={innerR:I,r:I}:c&&(C=c.end<=r.start?{innerR:I,r:I,start:m.end,end:m.end}:{innerR:I,r:I,start:m.start,end:m.start}));r=J}else C=n,r={};J=[n.plotX,n.plotY];if(!f.node.isLeaf)if(h===f.id){var v=g[h];v=v.parent}else v=f.id;z(f,{shapeExisting:n,tooltipPos:J,drillId:v,name:""+(f.name||f.id||f.index),plotX:n.plotX,plotY:n.plotY,value:k.val,isInside:u,isNull:!u});v=f.options;k=H(n)?n:{};v=H(v)?v.dataLabels:{};t=O(H(t)?t.dataLabels:
{})[0];t=B({style:{}},t,v);v=t.rotationMode;if(!L(t.rotation)){if("auto"===v||"circular"===v)if(1>f.innerArcLength&&f.outerArcLength>k.radius){var y=0;f.dataLabelPath&&"circular"===v&&(t.textPath={enabled:!0})}else 1<f.innerArcLength&&f.outerArcLength>1.5*k.radius?"circular"===v?t.textPath={enabled:!0,attributes:{dy:5}}:v="parallel":(f.dataLabel&&f.dataLabel.textPathWrapper&&"circular"===v&&(t.textPath={enabled:!1}),v="perpendicular");"auto"!==v&&"circular"!==v&&(y=k.end-(k.end-k.start)/2);t.style.width=
"parallel"===v?Math.min(2.5*k.radius,(f.outerArcLength+f.innerArcLength)/2):k.radius;"perpendicular"===v&&f.series.chart.renderer.fontMetrics(t.style.fontSize).h>f.outerArcLength&&(t.style.width=1);t.style.width=Math.max(t.style.width-2*(t.padding||0),1);y=y*K%180;"parallel"===v&&(y-=90);90<y?y-=180:-90>y&&(y+=180);t.rotation=y}t.textPath&&(0===f.shapeExisting.innerR&&t.textPath.enabled?(t.rotation=0,t.textPath.enabled=!1,t.style.width=Math.max(2*f.shapeExisting.r-2*(t.padding||0),1)):f.dlOptions&&
f.dlOptions.textPath&&!f.dlOptions.textPath.enabled&&"circular"===v&&(t.textPath.enabled=!0),t.textPath.enabled&&(t.rotation=0,t.style.width=Math.max((f.outerArcLength+f.innerArcLength)/2-2*(t.padding||0),1)));0===t.rotation&&(t.rotation=.001);f.dlOptions=t;if(!E&&u){E=!0;var W=G}f.draw({animatableAttribs:C,attribs:z(r,!q.styledMode&&a.pointAttribs(f,f.selected&&"select")),onComplete:W,group:d,renderer:x,shapeType:"arc",shapeArgs:n})});n&&E?(a.hasRendered=!1,a.options.dataLabels.defer=!0,r.prototype.drawDataLabels.call(a),
a.hasRendered=!0,A&&G()):r.prototype.drawDataLabels.call(a)};c.prototype.layoutAlgorithm=function(a,b,c){var d=a.start,f=a.end-d,e=a.val,h=a.x,g=a.y,k=c&&H(c.levelSize)&&L(c.levelSize.value)?c.levelSize.value:0,l=a.r,m=l+k,p=c&&L(c.slicedOffset)?c.slicedOffset:0;return(b||[]).reduce(function(a,b){var c=1/e*b.val*f,n=d+c/2,q=h+Math.cos(n)*p;n=g+Math.sin(n)*p;b={x:b.sliced?q:h,y:b.sliced?n:g,innerR:l,r:m,radius:k,start:d,end:d+c};a.push(b);d=b.end;return a},[])};c.prototype.setShapeArgs=function(a,
b,c){var d=[],f=c[a.level+1];a=a.children.filter(function(a){return a.visible});d=this.layoutAlgorithm(b,a,f);a.forEach(function(a,b){b=d[b];var f=b.start+(b.end-b.start)/2,e=b.innerR+(b.r-b.innerR)/2,h=b.end-b.start;e=0===b.innerR&&6.28<h?{x:b.x,y:b.y}:{x:b.x+Math.cos(f)*e,y:b.y+Math.sin(f)*e};var l=a.val?a.childrenTotal>a.val?a.childrenTotal:a.val:a.childrenTotal;this.points[a.i]&&(this.points[a.i].innerArcLength=h*b.innerR,this.points[a.i].outerArcLength=h*b.r);a.shapeArgs=B(b,{plotX:e.x,plotY:e.y+
4*Math.abs(Math.cos(f))});a.values=B(b,{val:l});a.children.length&&this.setShapeArgs(a,a.values,c)},this)};c.prototype.translate=function(){var a=this,c=a.options,e=a.center=b.call(a),h=a.startAndEndRadians=d(c.startAngle,c.endAngle),l=e[3]/2,p=e[2]/2-l,n=w(a),g=a.nodeMap,k=g&&g[n],u={};a.shapeRoot=k&&k.shapeArgs;r.prototype.translate.call(a);var z=a.tree=a.getTree();a.renderTraverseUpButton(n);g=a.nodeMap;k=g[n];var D=G(k.parent)?k.parent:"";D=g[D];var x=q.getLevelFromAndTo(k);var A=x.from,B=x.to;
x=M({from:A,levels:a.options.levels,to:B,defaults:{colorByPoint:c.colorByPoint,dataLabels:c.dataLabels,levelIsConstant:c.levelIsConstant,levelSize:c.levelSize,slicedOffset:c.slicedOffset}});x=q.calculateLevelSizes(x,{diffRadius:p,from:A,to:B});N(z,{before:m,idRoot:n,levelIsConstant:c.levelIsConstant,mapOptionsToLevel:x,mapIdToNode:g,points:a.points,series:a});c=g[""].shapeArgs={end:h.end,r:l,start:h.start,val:k.val,x:e[0],y:e[1]};this.setShapeArgs(D,c,x);a.mapOptionsToLevel=x;a.data.forEach(function(b){u[b.id]&&
E(31,!1,a.chart);u[b.id]=!0});u={}};c.defaultOptions=B(R.defaultOptions,{center:["50%","50%"],colorByPoint:!1,opacity:1,dataLabels:{allowOverlap:!0,defer:!0,rotationMode:"auto",style:{textOverflow:"ellipsis"}},rootId:void 0,levelIsConstant:!0,levelSize:{value:1,unit:"weight"},slicedOffset:10});return c}(R);z(l.prototype,{drawDataLabels:a,pointAttribs:c.prototype.pointAttribs,pointClass:n,utils:q});e.registerSeriesType("sunburst",l);"";return l});n(a,"masters/modules/sunburst.src.js",[],function(){})});
//# sourceMappingURL=sunburst.js.map