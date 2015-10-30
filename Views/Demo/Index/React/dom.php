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
        var InputName = React.createClass({
            getInitialState:function(){
                return {status:false};
            },
            search:function(){
                var e = ReactDOM.findDOMNode(this.refs.word),
                name = e.value;
                this.setState({status:true,data:null,name:name});
                  //url是临时找的一个,和本例没什么关联性,主要还是看逻辑吧
                  $.ajax({
                    url:'https://api.github.com/users/octocat/gists',
                    dataType:'jsonp',
                    success:function(data){
                        this.setState({status:false,data:data.data[0].url});
                    }.bind(this)
                });
            },

            render:function(){
                var output;
                if(this.state.status){
                    output = '请稍后';
                }
                if(this.state.data){
                   output = '搜索'+this.state.name+'的内容:'+this.state.data;
                }
               return  <div >
                            <input type="text" defaultValue="哈哈" ref="word" placeholder="请输入关键字"/>
                            <button onClick={this.search}>search</button>
                            <div>{output}</div>
                        </div>;
            }

        });
        ReactDOM.render(
            <InputName/>,
            document.querySelector("#content"));
    </script>
  </body>
</html>

 
