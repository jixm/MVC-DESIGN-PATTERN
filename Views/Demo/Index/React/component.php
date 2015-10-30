<?php
$this->display(VIEW.'Index/Public/Header.php');
?>
  <body>
  <style>
  	.title{
			width: 600px;
			height:60px;
			line-height : 60px;
			text-align : center;
			padding : 10px;
			margin:0 auto;
  	}
  </style>
  <div id="content"></div>
    <script type="text/babel">
    	var TitleShow = React.createClass({
	    	render:function(){
	    		var title = this.props.title;
		    	var e=React.createElement(
		    			'div',
		    			{className:'title'},
		    			React.createElement('h1',null,title)
		    		);
		    	return e;
    		}
    	
    	});
	    var e1 = React.createElement(TitleShow,{title:'Hello! I am coming..'});
	    ReactDOM.render(e1,document.querySelector("#content"));
    </script>
  </body>
</html>
