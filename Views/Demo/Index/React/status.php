  <?php
$this->display(VIEW.'Index/Public/Header.php');
?>
  <body>
<style>
  .BS{
    margin:100px 600px;
    background: red;
    font-size:70px;
    text-align: center;
  }
</style>
  <div id="content"></div>
    <script type="text/babel">
       var ButtonSwitch = React.createClass({
          getInitialState:function(){
              return {on:false};//初始状态为false 关闭
          },
          onClick:function(){
              this.setState({on:!this.state.on});
          },
          render:function(){
              var msg = this.state.on?'Opened':'Closed';
              return <button className='BS' onClick={this.onClick}>{msg}</button>
          }
       });
       ReactDOM.render(<ButtonSwitch />,document.getElementById('content'))
    </script>
  </body>
</html>

 