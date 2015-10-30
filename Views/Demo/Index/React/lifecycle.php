  <?php
$this->display(VIEW.'Index/Public/Header.php');
?>
  <body>
<style>
 .time-zone {
 
    margin:100px auto;
    font-weight:bold;
    font-size:50px;
    text-align: center;
 }
</style>
  <div id="content"></div>
    <script type="text/babel">
        function getTime(){
            var attr =['00','01','02','03','04','05','06','07','08','09'];  //补零
            var date = new Date();
            var h = date.getHours();
            var m = date.getMinutes();
            var s = date.getSeconds();
            return  [attr[h]||h,attr[m]||m,attr[s]||s].join(':');
        }
        var TimeShow = React.createClass({
            getInitialState:function(){
                return {time:getTime()};
            },
            //初次渲染后执行
            componentDidMount:function(){
              this.timer = setInterval(function(){
                  this.setState({time:getTime()});
              }.bind(this),1000);
            },
            //移除时执行
            componentWillUnmount:function(){  
                clearInterval(this.timer);
            },
            render:function(){
                return <div className='time-zone'>{this.state.time}</div>;
            }
        });
        ReactDOM.render(<TimeShow />,document.getElementById('content'));
    </script>
  </body>
</html>

 
