  <?php
$this->display(VIEW.'Index/Public/Header.php');
?>
  <body>
<style>
 div {
    margin:100px auto;
    font-weight:bold;
    font-size:50px;
    text-align: center;
 }
</style>
  <div id="content"></div>
    <script type="text/babel">
         var DefaultShow = React.createClass({
                propTypes: {
                    title: React.PropTypes.number.isRequired,//定义属性title必须且为数字
                },
                //生命默认属性值
                getDefaultProps:function(){
                    return { title:1 };
                },
                render:function(){
                    return <div>{this.props.title}</div>
                }
         });

         ReactDOM.render(<DefaultShow title="1234" />,document.getElementById('content'));
         //所设置的属性值与定义的属性类型不同会提示
         //```js Warning: Failed propType: Invalid prop `title` of type `string` supplied to `DefaultShow`, expected `number`.```
         // ReactDOM.render(<DefaultShow title='hello' />,document.getElementById('content'));
         // 属性title不设置,则会按默认属性设置走,输出1
         // ReactDOM.render(<DefaultShow  />,document.getElementById('content'));
    </script>
  </body>
</html>

 
