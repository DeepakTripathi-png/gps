var USAA=USAA||{};USAA.ecl=USAA.ecl||{};USAA.ecl.gnb=USAA.ecl.gnb||{};USAA.ecl.gnb.Badging=(function(){var D=document.getElementById("consolidated-pub");var A=function(G,I,F){if(D===null){if(G!==" "){document.getElementById("alerts-badge").style.display="inline-block";document.getElementById("alerts-badge").innerHTML=G}if(I==="true"){document.getElementById("profile-badge").style.display="inline-block"}if(G!==" "||I==="true"){var L=0;var M=0;if(G!==" "){M=parseInt(G)}if(I==="true"){L=1}var E=M+L;var K=document.getElementById("dropdown-badge");K.style.display="inline-block";document.getElementById("dropdown-badge").style.display="inline-block";document.getElementById("dropdown-badge").innerHTML=E}else{document.getElementById("dropdown-badge").style.display="none"}var N=document.getElementById("usaa-profile-tab");var J=document.getElementById("usaa-search-tab");if(F!==null){document.querySelector("#usaa-my-profile > span.nav-tab-text").style.visibility="visible";if(F!==""){document.querySelector("#usaa-my-profile > span.nav-tab-text").innerHTML=F}}var H=F.length;if(H>=1&&H<=3){N.className+=" tiny";J.className+=" tiny"}else{if(H>=4&&H<=6){N.className+=" small";J.className+=" small"}else{if(H>=9&&H<=11){N.className+=" large";J.className+=" large"}}}}};var C=function(E){if(D===null){var F=E.alertsBadgeValue;var G=E.isProfileUpdatedVal;var H=E.memFirstName;A(F,G,H)}};var B=function(G){if(G!==null){var F=document.getElementById("help-content");F.style.display="none";var E=document.getElementById("affinity-info");E.style.display="block";document.getElementById("affinity-number").innerHTML=G}};return{changeBadgingDomElementValues:A,GlobalNavProfileValues:C,affinityContactNumber:B}})();

if(typeof (USAA)==="undefined"){var USAA={ec:{}}}else{if(typeof (USAA.ec)==="undefined"){USAA.ec={}}}if(typeof (USAA.ec.util)==="undefined"){USAA.ec.util={}}var logWarning=USAA.hasOwnProperty("warning")?USAA.warning:function(){};USAA.ec.util.isLegacy=function(){try{return(typeof (window.addEventListener)!=="undefined")?false:true}catch(A){logWarning({app:"enterprise-wide",file:"/ec/utilities/enterpriseUtilityFunctions.js",source:"USAA.ec.util.enterpriseUtilityFunctions",message:"Error in isLegacy-"+A.name+":"+A.message})}};USAA.ec.util.hasClass=function(D,A){try{var C=D.className,E=new RegExp("(?:^|\\s+)"+A+"(?:\\s+|$)");return E.test(C)}catch(B){logWarning({app:"enterprise-wide",file:"/ec/utilities/enterpriseUtilityFunctions.js",source:"USAA.ec.util.enterpriseUtilityFunctions",message:"Error in hasClass-"+B.name+":"+B.message})}};USAA.ec.util.addClass=function(D,A){try{var C=D.className;if(USAA.ec.util.hasClass(D,A)){return true}if(C.length===0){D.className=A}else{D.className=C+" "+A}return true}catch(B){logWarning({app:"enterprise-wide",file:"/ec/utilities/enterpriseUtilityFunctions.js",source:"USAA.ec.util.enterpriseUtilityFunctions",message:"Error in addClass-"+B.name+":"+B.message})}};USAA.ec.util.removeClass=function(C,A){try{if(!USAA.ec.util.hasClass(C,A)){return false}C.className=C.className.replace(new RegExp("(?:^|\\s+)"+A+"(?:\\s+|$)")," ");if(USAA.ec.util.hasClass(C,A)){USAA.ec.util.removeClass(C,A)}return true}catch(B){logWarning({app:"enterprise-wide",file:"/ec/utilities/enterpriseUtilityFunctions.js",source:"USAA.ec.util.enterpriseUtilityFunctions",message:"Error in removeClass-"+B.name+":"+B.message})}};USAA.ec.util.toggleClass=function(D,A){try{var C=D.className;if(USAA.ec.util.hasClass(D,A)){USAA.ec.util.removeClass(D,A)}else{USAA.ec.util.addClass(D,A)}return true}catch(B){logWarning({app:"enterprise-wide",file:"/ec/utilities/enterpriseUtilityFunctions.js",source:"USAA.ec.util.enterpriseUtilityFunctions",message:"Error in toggleClass-"+B.name+":"+B.message})}};USAA.ec.util.get=function(B,A){try{var G=(B.substr(0,1)==="#")?true:false,H=(G)?"getElementById":"getElementsByClassName",F=A||window.document,C=B.substr(1,B.length),E;if(!F[H]){F[H]=function(J){var L=A.getElementsByTagName("*"),K,M=[],I;for(I=L.length;I--;){K=L[I].className;if(USAA.ec.util.hasClass(L[I],J)){M.push(L[I])}}return M}}E=F[H](C);return E}catch(D){logWarning({app:"enterprise-wide",file:"/ec/utilities/enterpriseUtilityFunctions.js",source:"USAA.ec.util.enterpriseUtilityFunctions",message:"Error in get-"+D.name+":"+D.message})}};USAA.ec.util.addListener=function(C,A,B,D){var H=USAA.ec.util.isLegacy(),E=(H)?"attachEvent":"addEventListener",G=(D)?D.slice(0):[],F=(H||D)?function(J){B.call(C,J,G)}:B,I=(H)?"on"+A:A;C[E](I,F,false);return F};USAA.ec.util.removeListener=function(D,B,E){var A=USAA.ec.util.isLegacy(),F=(A)?"detachEvent":"removeEventListener",C=(A)?"on"+B:B;D[F](C,E,false)};USAA.ec.util.getTarget=function(E){try{var A=USAA.ec.util.isLegacy(),D=(A)?E.srcElement:E.target,C=D.parentNode,F=(C.nodeName.toUpperCase()==="A")?(C.nodeName.toUpperCase()==="A"):(C.nodeName.toUpperCase()==="BUTTON");while(!F&&C.nodeName.toUpperCase()!=="#DOCUMENT"&&D.nodeName.toUpperCase()!=="A"&&D.nodeName.toUpperCase()!=="BUTTON"){C=C.parentNode;F=(C.nodeName.toUpperCase()==="A")?(C.nodeName.toUpperCase()==="A"):(C.nodeName.toUpperCase()==="BUTTON")}return(F)?C:D}catch(B){logWarning({app:"enterprise-wide",file:"/ec/utilities/enterpriseUtilityFunctions.js",source:"USAA.ec.util.enterpriseUtilityFunctions",message:"Error in getTarget-"+B.name+":"+B.message})}};

if(typeof USAA=="undefined"){var USAA={}}var dojoConfig={baseUrl:document.location.protocol+"//"+document.location.hostname+"/javascript/ent/desktop_inf/comet/dojo/"};USAA.namespace=function(){var A=arguments,E=null,D=0,C=0,B=null;for(D=0;D<A.length;D=D+1){B=A[D].split(".");E=USAA;for(C=(B[0]=="USAA")?1:0;C<B.length;C=C+1){E[B[C]]=E[B[C]]||{};E=E[B[C]]}}return E};

var USAA=USAA||{};USAA.ecl=USAA.ecl||{};USAA.ecl.gnb=USAA.ecl.gnb||{};USAA.ecl.gnb.SubGlobal=USAA.ecl.gnb.SubGlobal||{};USAA.ecl.gnb.SubGlobal.SubGlobalMenu=(function(){var J=false;var B=document;var K=(B.URL.indexOf("/inet"));var C=B.URL.substring(0,K);var N=C+"/inet/ent_accounts/EntAccountSummary?action=INIT&launchapp=myaccounts";var H=C+"/inet/pages/our-products-main?wa_ref=pri_global_my_accounts_viewproducts";var F=C+"/inet/ent_home/CpHome?action=init&wa_ref=pri_global_my_accounts_viewall";var I,E,O;var G=530;var M={html:{MY_ACCOUNTS_DB_ERROR:'<div class="myAccMessage"><p><span class="messageError">Some of your account information is unavailable at this time. We apologize for any inconvenience.</span></p></div>',NO_ACCOUNTS_MESSAGE:'<div class="myAccMessage"><span class="messageInfo">You currently have no accounts.</span></div>',SPAN_ICON:'<span role="presentation" aria-hidden="true" class="nav-sprite icon-chevron-dark"></span>',ACC_OPEN_MESSAGE:"My Accounts Menu. Details showing. Click to hide.",ACC_CLOSED_MESSAGE:"My Accounts Menu. Details hidden. Click to show."}};var D=function(z){var AM=0;var AJ=4;var AD=7;var u=z;var X=B.createElement("DIV");X.innerHTML=u;var R=X.getElementsByTagName("DIV");var e=B.createElement("DIV");var AE,f,d,r,h,T,s,Y,AL,AN,g,AA,W,w,AG;var c=false;var AC=0;for(var AH=0;AH<R.length;AH++){if(R[AH].id==="GROUPACCOUNTSLIST"){e=R[AH]}if(USAA.ec.util.hasClass(R[AH],"dbError")){AE=R[AH]}}var Z=false||(AE?true:false);var S=e.getElementsByTagName("DIV");var a=S.length;var p=/home_value_monitoring_main/;var b=/SafeDrivingServlet/;var AB=/DriveSharpServlet/;var n=USAA.ec.util.get(".loadingIcon",I)[0];var AK=USAA.ec.util.get(".usaa-global-nav-content",I)[0];var U=USAA.ec.util.get(".usaa-global-nav-wrap",I)[0];var AO=B.createElement("div");AO.setAttribute("class","colum-wrap clearfix group-v10-wrap");AK.appendChild(AO);E.removeChild(n);USAA.ec.util.addClass(E,"hidden");if(Z){AO.innerHTML=M.html.MY_ACCOUNTS_DB_ERROR}if(S.length===0){AO.innerHTML=M.html.NO_ACCOUNTS_MESSAGE;G=375}if(O){r=B.createElement("div");r.className="navigation-myaccounts-all-footer ft bottom-left-right-inner-corners group-item";var v=B.createElement("span");USAA.ec.util.addClass(v,"navigation-footer-heading group-item");var t=B.createElement("a");USAA.ec.util.addClass(t,"navigation-myaccounts-footer-link item-link");t.setAttribute("href",H);t.innerHTML="View All USAA Products";v.appendChild(t);r.appendChild(v)}var x=B.createElement("div");USAA.ec.util.addClass(x,"subMenuFooter");var AI=B.createElement("div");USAA.ec.util.addClass(AI,"leftCorner");var V=B.createElement("div");USAA.ec.util.addClass(V,"rightCorner");x.appendChild(AI);x.appendChild(V);AK.appendChild(x);for(AH=0;AH<a;AH++){w=B.createElement("div");w.className="column";W=B.createElement("div");W.className="group-v10-wrap";f=B.createElement("ul");f.className="group";T=S[AH].getElementsByTagName("A");s=T.length;Y=s>AD?AD:s;AL;if(s!==0){if(!c){d=B.createElement("li");d.className="group-item item-title";d.setAttribute("id","myAccountsHome");h=B.createElement("A");h.className="item-link title-item-link";h.setAttribute("href",F);h.innerHTML="All My Accounts";d.appendChild(h);c=true}AM++;G=parseInt(G)+parseInt(-100);d=B.createElement("li");d.className="group-item item-title";AL=S[AH].getAttribute("id");d.innerHTML='<span class="item-link title-item-link">'+AL+"</span>";f.appendChild(d);W.appendChild(f);AO.appendChild(w);w.appendChild(W);if(AC===0){W.appendChild(r);AC++}}else{continue}for(var AF=0;AF<=Y;AF++){AN=T[AF];if(AN&&AN.href!==""){d=B.createElement("li");h=B.createElement("A");h.className="item-link";if(AF===AD){d.className="group-item last-item";g="View All ";AA=F}else{if(Y-1===AF&&AF!==AD-1){d.className="group-item last-item"}else{d.className="group-item"}var m=AN.childNodes[0].nodeValue;g=m.replace(/^\s+|\s+$/g,"");if((AN.href).search(p)!==-1&&(AN.href).indexOf("?")===-1){AA=AN.href+"?wa_ref=pri_global_my_accounts_hover"}else{if((AN.href).search(b)!==-1&&(AN.href).indexOf("?")===-1){AA=AN.href+"?wa_ref=pri_global_my_accounts_hover"}else{if((AN.href).search(AB)!==-1&&(AN.href).indexOf("?")===-1){AA=AN.href+"?wa_ref=pri_global_my_accounts_hover"}else{AA=AN.href+"&wa_ref=pri_global_my_accounts_hover"}}}}h.setAttribute("href",AA);h.innerHTML=g;d.appendChild(h);f.appendChild(d)}}W.appendChild(f);if(AM>=AJ){G=0;break}}if(a===0){w=B.createElement("div");w.className="column";AO.appendChild(w);W=B.createElement("div");W.className="group-v10-wrap";w.appendChild(W);W.appendChild(r)}var q=AO.childNodes;AG="column";if(q.length>0&&S.length!==0){for(AH=0;AH<q.length;AH++){if(AH===0){q[AH].className="column column-first"}else{q[AH].className=AG}}if(Z){q[0].className="myAccColumn-Error"}}var y=USAA.ec.util.get(".my-accounts");y[0].style.left="-221px";if(AM===0){y[0].style.left="475px";U.style.width="970px"}if(/MSIE (\d+\.\d+);/.test(navigator.userAgent)&&I){var l=Number(RegExp.$1);if(l===7){y[0].style.top="61px";if(AM>3){if(AM===5){U.style.width="920px";y[0].style.left="0px"}else{U.style.width="800px";y[0].style.left="25px"}}else{if(AM!==0){U.style.width=parseInt(AM)*parseInt(225)+"px";y[0].style.left=parseInt(500)-parseInt(AM)*parseInt(100)+"px"}}}}if(O===null){y[0].style.left="0"}};var A=function(S){var R=USAA.ec.util.get(".acc-touch-menu-content",I)[0];var T=USAA.ec.util.get(".loadingIcon",I)[0];R.innerHTML=M.html.MY_ACCOUNTS_DB_ERROR;E.removeChild(T);USAA.ec.util.addClass(E,"hidden")};var Q=function(R){if(!J){var S;if(window.XMLHttpRequest){S=new XMLHttpRequest()}var T=(typeof XMLHttpRequest.Done!=="undefined")?XMLHttpRequest.Done:4;S.onreadystatechange=function(){if(S.readyState===T){if(S.status===200){D(S.responseText)}else{A(R)}}};S.open("GET",N,true);S.send()}J=true};var L=function(S){E=B.createElement("div");var R=document.querySelectorAll(".my-accounts")[0];E.style.textAlign="center";E.style.padding="5px";if(O){E.setAttribute("class","myAccountsLoader my-accounts-cols-1 myAccMessage center-menu navigation-menu_border bottom-left-right-corners dropdown_menu_shadow")}else{E.setAttribute("class","myAccountsLoader preteen myAccountsLoader my-accounts-cols-1 myAccMessage center-menu navigation-menu_border bottom-left-right-corners dropdown_menu_shadow")}E.innerHTML="<span class='loadingIcon'></span>";R.appendChild(E);Q(S);return true};var P=function(V){if(V==="true"){I=document.getElementById("usaa-my-accounts-tab-menu");L(I)}else{try{O=document.getElementById("usaa-our-products-tab");I=document.getElementById("usaa-my-accounts-tab-menu");if(O){USAA.ec.accTouchMenu.init("usaa-our-products-tab");USAA.ec.accTouchMenu.init("usaa-your-life-events-tab");USAA.ec.accTouchMenu.init("usaa-help-tab");USAA.ec.accTouchMenu.init("usaa-search-tab");USAA.ec.accTouchMenu.init("usaa-login-tab");if(I){USAA.ec.accTouchMenu.init("usaa-claims-center-tab");USAA.ec.accTouchMenu.init("usaa-profile-tab");USAA.ec.accTouchMenu.init("usaa-my-tools-tab");USAA.ec.accTouchMenu.init("usaa-my-accounts-tab-menu",{initSubGlobal:P})}}}catch(T){}var U=document.getElementById("usaa-my-accounts-tab");var R=document.createElement("span");USAA.ec.util.addClass(R,"hiddenMessage");R.innerHTML=" (Tab is Active)";if(U){var S=USAA.ec.util.hasClass(U,"active");if(S){var W=U.getElementsByTagName("a")[0];W.appendChild(R);USAA.ec.util.addClass(I,"active")}}}};return{initSubGlobal:P}})();

if(typeof (USAA)==="undefined"){var USAA={ec:{}}}else{if(typeof (USAA.ec)==="undefined"){USAA.ec={}}}USAA.ec.accTouchMenu=(function(d){var Q=window;var H=Q.document;var D=H.body;var W={};var R={leftArrow:37,upArrow:38,rightArrow:39,downArrow:40,tab:9,shift:16,esc:27,enter:13};var c=USAA.ec.util.isLegacy();var b=false;var N="true";var T={click:"click",classNames:{menuWrapper:"acc-touch-menu-wrapper",menuToggle:"acc-touch-menu-toggle",menuContent:"acc-touch-menu-content",menuVisible:"acc-touch-menu-visible",menuReady:"acc-touch-menu-ready",hiddenMsg:"hiddenMessage",menuToggleOpen:"acc-touch-menu-toggle-open",menuToggleClosed:"acc-touch-menu-toggle-closed",myAccounts:"usaa-my-accounts-tab-menu",chevron:"chevron"}};var J=USAA.hasOwnProperty("log")?USAA.log:function(){};var Y=navigator.userAgent;var E=Y.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);function F(q,o,m,k){var j,l,h;var p="";p+="Our _ABSTRACTS object: "+T;p+=" Menu instances currently available: "+W;if(k){var f={};var g=k.length;for(l=0,h=g;l<h;l++){j=k[l];f[j]=window[j]}p+=" | Your requested arguments: "+f}p+=" | Error in "+q+" - "+o.name+": "+o.message+" - Browser Details:"+E[0];J({logType:"error",logSubType:m,app:"enterprise-wide",file:"/ec/apps/acc_touch/accTouchMenu.js",source:"USAA.ec.apps.acc_touch.accTouchMenu",message:p});return true}function M(h){try{var g;for(g in W){if((W[g].isOpen)&&(W[g]!==h)){P(W[g])}}USAA.ec.util.addClass(h.wrapper,T.classNames.menuVisible);if(h.menu.getAttribute("id")==="profile-wrap"){USAA.ec.util.removeClass(h.menu,"close");if(USAA.ec.util.hasClass(h.menu,"hidden")){USAA.ec.util.removeClass(h.menu,"hidden")}if(document.getElementById("messageLoginErrorDiv")){if(document.getElementById("messageLoginErrorDiv").style.display!=="none"){removeErrorMessageDiv()}}}else{USAA.ec.util.removeClass(h.menu,"hidden")}if(USAA.ec.util.hasClass(h.toggle,"touch-menu-tab")){h.navMask.style.display="block"}h.eventListenerHandle=USAA.ec.util.addListener(H,T.click,S,[h]);h.isOpen=true;h.toggle.setAttribute("aria-expanded","true");h.toggle.blur();if(h.currentNavItem!==-1){h.currentNavItem=-1}if(h.navItems.length>0&&USAA.ec.util.hasClass(h.wrapper,"firstItemFocusFlag")){var e=h.navItems[0];e.focus()}else{h.toggle.focus()}}catch(f){F("_openMenu",f,"critical")}}function P(f){try{USAA.ec.util.removeClass(f.wrapper,T.classNames.menuVisible);if(f.menu.getAttribute("id")==="profile-wrap"){USAA.ec.util.addClass(f.menu,"close")}else{USAA.ec.util.addClass(f.menu,"hidden")}f.isOpen=false;f.currentNavItem=-1;f.toggle.setAttribute("aria-expanded","false");f.toggle.blur();f.toggle.focus();USAA.ec.util.removeListener(H,T.click,f.eventListenerHandle);if(f.eventListenerHandle){f.navMask.style.display="none";delete f.eventListenerHandle}}catch(e){F("_closeMenu",e,"critical")}}function a(f){try{if(f.isOpen){P(f)}else{b=false;if(f.wrapper.id===T.classNames.myAccounts&&N==="true"){USAA.ecl.gnb.SubGlobal.SubGlobalMenu.initSubGlobal(N);N="false"}M(f)}}catch(e){F("_toggleMenu",e,"critical")}}function S(l,h){try{var k=l||event;var m=h[0];var j=USAA.ec.util.getTarget(k);var f=j.parentNode;var g=true;while(g&&(f)&&(f!==D)){if(f===m.wrapper){g=false}f=(f.parentNode)||D}if(g){P(m)}}catch(i){F("_clickOut",i,"warning")}}function L(g){try{(c)?g.returnValue=false:g.preventDefault()}catch(f){F("_preventScreenJitters",f,"warning")}}function I(j){var i=j.target||j.srcElement;if(i.nodeName!=="INPUT"){try{var g=j||event;var h=g.keyCode||1;if(h===0){h=1}switch(h){case 1:X.apply(this,arguments);break;case (R.shift):Z.apply(this,arguments);break;case (R.leftArrow):B.apply(this,arguments);break;case (R.rightArrow):C.apply(this,arguments);break;case (R.downArrow):U.apply(this,arguments);break;case (R.upArrow):G.apply(this,arguments);break;case (R.tab):O.apply(this,arguments);break;case (R.esc):V.apply(this,arguments);break;case (R.enter):break}}catch(f){F("_handleEvent",f,"critical")}}}function X(j){try{var h=j||event;var g=USAA.ec.util.getTarget(h);var l=this;var k=W[l.id];var i=(g===k.toggle)?true:false;if(i){a(k)}}catch(f){F("_onClick",f,"critical")}}function Z(h){try{var f;if(!b){b=true;f=USAA.ec.util.addListener(H,"keyup",function(){var i=h||event;var e=(window.document.Event)?i.which:i.keyCode;if(e===R.shift){b=false;USAA.ec.util.removeListener(H,"keyup",f)}})}}catch(g){F("_onShiftKey",g,"warning")}}function B(h){try{var g=h||event;L(g)}catch(f){F("_onLeftArrowKey",f,"warning")}}function C(h){try{var g=h||event;L(g)}catch(f){F("_onRightArrowKey",f,"warning")}}function U(l){try{var p=l||event;var o=USAA.ec.util.getTarget(p);var h=this;var q=W[h.id];q.navItems=q.menu.querySelectorAll("a,input,button");var f=q.isOpen;var m=q.currentNavItem;var i=m-1;var k=m+1;var j=q.navItems[k];var g=q.navItems[i];L(p);if((!f)&&(o===q.toggle)){if(q.wrapper.id===T.classNames.myAccounts&&N==="true"){q.initSubGlobal(N);N="false"}M(q)}if(q.navItems.length>1){if(j){q.currentNavItem=k}else{if(g){q.currentNavItem=k=0;j=q.navItems[k]}else{return }}j.focus()}}catch(n){F("_onDownArrowKey",n,"warning")}}function G(l){try{var o=l||event;var h=this;var p=W[h.id];p.navItems=p.menu.querySelectorAll("a,input,button");var f=p.isOpen;var m=p.currentNavItem;var i=m-1;var k=m+1;var j=p.navItems[k];var g=p.navItems[i];L(o);if(p.navItems.length>1&&f){if(g){p.currentNavItem=i}else{if(j){p.currentNavItem=i=(p.navItems.length-1);g=p.navItems[i]}else{P(p);p.toggle.focus();return }}g.focus()}}catch(n){F("_onUpArrowKey",n,"warning")}}function O(k){try{var o=k||event;var n=USAA.ec.util.getTarget(o);var g=this;var q=W[g.id];q.navItems=q.menu.querySelectorAll("a,input,button");var f=q.isOpen;var l=q.currentNavItem;var h=l-1;var j=l+1;var i=q.navItems[j];if(f&&(((n===q.toggle)&&b)||((!i)&&(!b)))){P(q)}else{q.currentNavItem=(b)?h:j}if(b&&(n===q.navItems[0])){var p=o||window.event;if(p.preventDefault){p.preventDefault()}else{p.returnValue=false;p.cancelBubble=true}P(q);b=false;q.toggle.focus()}if(!b&&n===q.navItems[q.navItems.length-1]){P(q);b=false}}catch(m){F("_onTabKey",m,"warning")}}function V(g){try{var i=this;var h=W[i.id];if(h.isOpen){P(h);h.toggle.focus()}}catch(f){F("_onEscapeKey",f,"warning")}}function A(f){try{USAA.ec.util.addClass(f.menu,"hidden");USAA.ec.util.addClass(f.wrapper,T.classNames.menuReady)}catch(e){F("_renderMenu",e,"critical")}}function K(h,j){try{var g=j||{};var i,f;if(!(f=USAA.ec.util.get("#"+h))){return false}if(typeof (W[h])!=="undefined"&&(!USAA.ec.util.hasClass(f,"firstItemFocusFlag")&&!USAA.ec.util.hasClass(f,"my-accounts-tab-menu"))){return true}i={wrapper:f,toggle:USAA.ec.util.get("."+T.classNames.menuToggle,f)[0],menu:USAA.ec.util.get("."+T.classNames.menuContent,f)[0],navMask:document.getElementById("navigationmask-container"),currentNavItem:-1,isOpen:false};i.navItems=i.menu.querySelectorAll("a,input,button");if(h===T.classNames.myAccounts){i.initSubGlobal=g.initSubGlobal}A(i);USAA.ec.util.addListener(f,T.click,I);USAA.ec.util.addListener(f,"keydown",I);W[h]=i;return true}catch(e){F("_init",e,"critical")}}return{init:K,openMenu:M}}());

var USAA=USAA||{};USAA.ecl=USAA.ecl||{};USAA.ecl.gnb=USAA.ecl.gnb||{};USAA.ecl.gnb.common=USAA.ecl.gnb.common||{};USAA.ecl.gnb.common.attachActionItems=function(L,O){function N(R){var S=isProperty(R.keyCode)?R.keyCode:R.which;if(S===9&&!R.shiftKey){setTimeout(function(){document.Logon.j_password.focus()},50)}}var F=(document.URL.indexOf("/inet"));var A=document.URL.substring(0,F);var B=document.getElementById("searchForm1");B.action=L;if(document.getElementById("consolidated-pub")){var J=document.getElementById("Logon");J.action=O;J.onsubmit=function(){document.getElementById("j_username").value=document.getElementById("usaaNum").value;document.getElementById("j_password").value=document.getElementById("usaaPass").value;return USAA.ec.logon.HandleLogonSubmit()};var Q=document.getElementById("usaaNum");Q.onkeydown=function(R){N(R)};Q.onkeypress=function(){removeErrorMessageDiv()};var H=document.querySelectorAll(".forgot-id")[0];H.href=A+"/inet/ent_proof/proofingEvent?action=Init&event=forgotOnlineId&wa_ref=pub_auth_nav_forgotid";var G=document.querySelectorAll(".forgot-password")[0];G.href=A+"/inet/ent_proof/proofingEvent?action=Init&event=forgotPassword&wa_ref=pub_auth_nav_forgotpwd";var K=document.querySelectorAll(".register")[0];K.href=A+"/inet/ent_proof/proofingEvent?action=Init&event=registration&wa_ref=pub_auth_nav_register";var P=document.querySelectorAll(".security")[0];P.href=A+"/inet/pages/security_center?wa_ref=pub_auth_nav_sec";var C=window.location.href;document.getElementById("authBarLogonUrl").value=C}if(document.getElementById("messageLoginErrorDiv")&&document.getElementById("messageLoginErrorDiv").style.display===""){var D=document.getElementById("usaa-login-tab");D.setAttribute("class","navigation-tab profile-tab navigation-inner-container acc-touch-menu-wrapper firstItemFocusFlag acc-touch-menu-ready acc-touch-menu-visible");var I=document.getElementById("profile-wrap");I.setAttribute("class","usaa-global-nav-wrap global-nav-usaa-profile-wrap profile navigation-menu_border acc-touch-menu-content");var E=document.getElementById("navigationmask-container");var M=document.getElementById("usaa-login-tab");if(M&&M.style.display!=="none"){E.style.display="block"}document.getElementById("usaaNum").focus()}};USAA.ecl.gnb.common.addCSRFToken=function(B){var A=document.getElementById("gn_loginform_csrftoken");if(A){A.value=B}};function isUrlContainsWord(B){var A=window.location.href;if(A.indexOf(B)>-1){return true}else{return false}}setTimeout(function(){if(isUrlContainsWord("redirectedFromLogOff")){var C=document.getElementById("usaa-login-tab");var A=document.getElementById("usaa-my-profile");var B=document.getElementById("profile-wrap");var D={wrapper:C,toggle:A,menu:B,navMask:document.getElementById("navigationmask-container"),currentNavItem:-1,isOpen:false};USAA.ec.accTouchMenu.openMenu(D)}},800);

var USAA=USAA||{};USAA.ecl=USAA.ecl||{};USAA.ecl.gnb=USAA.ecl.gnb||{};USAA.ecl.gnb.behavior=USAA.ecl.gnb.behavior||{};USAA.ecl.gnb.behavior.ClientAutoCompleteBehavior=function(){var I,F,U,M;var E="search";var R=10;var C=(document.URL.indexOf("/inet"));var J=document.URL.substring(0,C);var N=J+"/inet/ent_search/SearchAutoCompleteServlet";var P="\n";var S="true";var V=-1;var B=function(X,W){var Z=[];for(var Y=0;Y<X.length;Y++){Z.push(W(X[Y]))}return Z};var G=function(Z,W){var Y=Z;for(var X in W){if(W[X]!==""){Y=Y.replace(W[X],"<b>"+W[X]+"</b>")}}return Y};var Q=function(X,W){return B(W,function(Y){var Z=Y;var e=Z.indexOf(X);var d=Z.substring(0,e);var b=Z.substring(e+X.length);var c=[d,b];var a=G(Z,c);return'<div class="autoComplete-liner" style="margin:0 0 0 95px;">'+a+"</div>"})};var K=function(b){var X=document.getElementById(b.inputNode);var Y=b.maxResults;var c=b.resultFormatter;var d=this;var a=function(h,g){var k=[];for(var j=0;k.length<Y&&j<g.length;j++){if((g[j].toUpperCase()).match(h)){k.push(g[j])}}return k};var Z=function(j,h,i,g){j[h].style.background=i;j[h].style.color=g};var e=function(g){if(d.source){var l,o,m,n;var p=U.value;var j=p.toUpperCase();if(j!==""){l=a(j,d.source);o=c(p,l);F=F||document.createElement("div");F.setAttribute("id","output");if(o.length>0){F.innerHTML=o.toString().replace(/,/g,"");U.parentNode.appendChild(F)}else{if(document.getElementById("output")){U.parentNode.removeChild(F)}}}else{V=-1;if(document.getElementById("output")){U.parentNode.removeChild(F)}}var h=F.getElementsByTagName("div");for(var k=0;k<h.length;k++){h[k].onmouseover=function(){this.style.backgroundColor="#436A8C";this.style.color="white";this.onclick=function(){m=this.innerHTML;n=m.replace(/<(?:.|\n)*?>/gm,"");U.value=n;document.getElementById("searchForm1").submit()}};h[k].onmouseout=function(){this.style.backgroundColor="white";this.style.color="black"}}if(M===40){if(V>=0&&V<10){Z(h,V,"white","black");Z(h,++V,"#436A8C","white")}else{if(V===10){V=-1}Z(h,++V,"#436A8C","white")}}if(M===38){if(V>0){Z(h,V,"white","black");Z(h,--V,"#436A8C","white")}else{V=9}}if(V>=0){m=h[V].innerHTML;n=m.replace(/<(?:.|\n)*?>/gm,"")}else{n=U.value}if(M===13){U.value=n;document.getElementById("search").setAttribute("value",n);document.getElementById("searchForm1").submit()}}};var f=document.querySelectorAll(".clear-search")[0];if(f.addEventListener){f.addEventListener("click",function(){if(document.getElementById("output")){U.parentNode.removeChild(F)}})}else{if(f.attachEvent){f.attachEvent("onclick",function(){if(document.getElementById("output")){U.parentNode.removeChild(F)}})}}var W=function(h,g){d[h]=g};if(X.addEventListener){X.addEventListener("keyup",function(g){M=g.keyCode;U=g.target;setTimeout(e(g),500)})}else{if(X.attachEvent){X.attachEvent("onkeyup",function(g){M=g.keyCode;U=g.srcElement;setTimeout(function(){e(g)},500)})}}return{set:W}};var D=function(){I=new K({inputNode:E,maxResults:R,resultFormatter:Q,resultFilters:(S)?"phraseMatch":"startsWith",render:true})};var A=function(X){if(X!==undefined){var Y=X.replace(/\r/gm,"");var W=Y.split(P);I.set("source",W)}};var H=function(){};var L=function(){return new XMLHttpRequest()};var O=function(X,W,Z){var a=L();var Y=(typeof XMLHttpRequest.Done!=="undefined")?XMLHttpRequest.Done:4;a.onreadystatechange=function(){if(a.readyState===Y){if(a.status===200){W(a.responseText)}else{Z()}}};a.open("GET",X,true);a.send()};(function T(){D(E);O(N,A,H)})();return{instance:I}};


