#《CSS那些事儿》布局篇

本篇中主要介绍DOCTYPE、盒模型的理解以及一些设计原则，以及常见的两列，三列或多列页面布局的实现方式...

1. 文档类型
 * STRICT（严格型）
 * TRANSITION（过渡类型）
 * FRAMESET(框架类型）

2. 盒模型
 * 盒模型的计算
 * 盒模型的不同表现形式
 * 怪异模式下盒模型的计算

3. 设计原则

4. 两列定宽结构
 * 两列定宽、定高
 * 两列定宽、自适应高度
 * 负边距应用

5. 两列宽度自适应结构

6. 单列定宽、单列自适应结构

7. 两列等高
 * 背景模拟
 * 负边距实现
 * 边框模拟
 * JavaScript脚本

8. 两列定宽，中间自适应结构

9. 左侧定宽，右侧及中间自适应结构

10. 三列宽度自适应结构

## 一、文档类型

DOCTYPE即DTD声明，用于指定页面所使用XHTML或HTML的版本。


### 1. STRICT（严格型）

 

```<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">```

### 2. TRANSITION（过渡类型）

```<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">```

### 3. FRAMESET(框架类型）

```<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/Xhtml1/DTD/xhtml1-frameset.dtd">```


## 二、盒模型

页面任何元素都是以矩形方式存在，如DIV标签。
如果元素加上背景，那么该背景也将出现在“padding”中。
使用“margin”可以将相邻元素推开，反之“-margin”可以吸附到身边。

### 1. 盒模型的计算

#### 1.1 盒模型实际宽：

margin-left + border-left-width + padding-left + width + padding-right + border-right-width + margin-right

#### 1.2 盒模型实际高：

margin-top + border-top-width + padding-top + height + padding-bottom + border-bottom-width + margin-bottom


### 2. 盒模型的不同表现形式

IE存在两种渲染：Quirks(怪异模式）、Standard（标准模式）
触发怪异模式条件之一是DTD错误。
怪异模式会根据内容自适应高度。

### 3. 怪异模式下盒模型的计算

#### 3.1 理想状态

border和padding计入了width值，故width实际占据了“width-border-padding”

margin + width + margin

#### 3.2 其他状态

宽：标准值 + 20px
高：标准值 + 38px

## 三、设计原则

### 1. 注意样式重用性（使用外联样式表、重复内容用Class选择符）
### 2. 注意浮动和清除浮动
### 3. 页面布局中的定位方式（绝对定位布局要慎重）
### 4. 避免过度使用ID选择符（ID在一个页面只出现一次）
### 5. 避免选择符使用“字母+数字”命名
### 6. 勿盲目使用最求CSS布局（JS还是要用滴）

##四、两列定宽结构

```
头部信息
主要内容区域

侧边栏
底部信息
```

###1. 两列定宽、定高

方法：宽高确定，mainBox、SideBox左右浮动。

缺点：内容过多超出高度后会溢出。


###2. 两列定宽、自适应高度

方法：去掉container、mainBox、SideBox高度，mainBox、SideBox左右浮动、footer清除左右浮动（必须）。

注意：footer清除浮动不能直接使用“clear:both”，否则footer会紧挨container。只能对container使用overflow或伪类:after来清除浮动。


###3. 负边距应用

如果mainBox、SideBox宽度之和大于container宽度，将导致错位。为此可对SideBox应用负边距“margin-left:-XX”，或对mainBox应用“margin-right:-XX”。

原理：外边距margin的作用是增加容器与容器的间距，负值是减少间距。

负边距margin示意图

![http://wangyan.org/pic/m/margin.PNG](vv)

##五、两列宽度自适应结构

方法：将mainBox、SideBox宽度单位px改为百分比。（注意该宽度并不是盒模型的总宽度，而是盒模型内容区域width的宽度。）

缺点：IE7及以下版本出现错位。解决方法：#footer{width:100%}或#footer{clear:both}


##六、单列定宽、单列自适应结构

方法：mainBox 宽70%、SideBox 宽200px

缺点：缩小窗口会错位、用负边距解决，则mainBox与SideBox内容会重叠。

解决方法：浮动及清除浮动失效，无法撑开父级元素高度，可用JS解决。

```css
#container { position:relative; } .mainBox { width:auto; margin-right:200px; } .sideBox { position:absolute; top:0px; right:0px; width:200px; margin-left:-200px; }
```

##七、两列等高


###1. 背景模拟

方法：背景Y轴平铺，即Repeat-y

缺点：宽度必须确定、经常要修改图片。


###2. 负边距实现

```css
#container{ overflow:hidden; //完全清除浮动，以自适应高度 } .mainBox, .sideBox{ padding-bottom:9999px; margin-bottom:-9999px; } #container:after{ display;block; visibility:hidden; font-size:0; line-height:0; clear:both; content:""; //清除左右浮动 }
```

###3. 边框模拟

缺点：不能使用背景图片、必须保证一边高度不能大于另一边（mainBox ）

```css
#container{ position:relative; } .mainBox { float:left; width:680px; border-right:280px solid #AAAAAA; } .sideBox { position:absolute; top:0; right:0; width:280px; } #container:after { display:block; visibility:hidden; font-size:0; line-height:0; clear:both; content:""; } /* 清除内容区域的左右浮动 */
```

###4. JavaScript脚本

##八、两列定宽，中间自适应结构

###1. width默认值与float关系

* 1. 如果width=auto（默认值），则width=浏览器窗口所能显示的最大值。
* 2. 如果width=auto，且有float属性，则width=随盒模型中内容而变化。

###2. HTML结构
```
头部信息
主要内容区域
次内容区域
侧边栏
底部信息
```

###3. CSS样式

思路：mainBox左浮动，且宽度100%占据一行；其子元素content宽度为auto，且用margin(不用padding)为其左右留下空白；subMainbox、sideBox利用负边距原理被吸到content的左右空白区域，注意的是subMainbox负边距为"-100%"而非"-300px"...

```css
.mianBox{ float:left; width:100%; background:#FFF; } .mianBox .content{ margin:0 210px 0 310px; background:#000; } subMainBox{ float:left; width:300px; margin-left:-100%; background:#666; } .sideBox{ float:left; width:200px; margin-left:-200px; background:#666; }
```

##九、左侧定宽，右侧及中间自适应结构

这个很好理解，沿用上面代码，并修改以下部分。

```css
.mianBox .content{ margin:0 41% 0 310px; background:#000; } .sideBox{ float:left; width:40%; margin-left:-40%; background:#666; }
```

##十、三列宽度自适应结构

```css
.mianBox .content{ margin:0 21% 0 41%; background:#000; } .subMainBox{ float:left; width:40%; margin-left:-100%; background:#666; } .sideBox{ float:left; width:20%; margin-left:-20%; background:#666; }
```