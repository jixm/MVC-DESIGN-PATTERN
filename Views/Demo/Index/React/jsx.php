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
            return <div className='title'><h1>{title}</h1></div>;
       }
     });
      ReactDOM.render(
          <TitleShow  title="Hello! I am coming.." />
          ,
          document.getElementById('content')
        );
    </script>
  </body>
</html>

 