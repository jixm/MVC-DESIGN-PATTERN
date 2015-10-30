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
        var EzLoginComp = React.createClass({
            auth : function(event){
                var account = React.findDOMNode(this.refs.account).value,
                    pass = React.findDOMNode(this.refs.password).value;
                alert([account,pass]);  
                    
            },
            render : function(){

                return  <div className = "ez-login">
                            <div className="row title">
                                <h1>登录</h1>
                            </div>
                            <div className="row account">
                                <label>用户</label>
                                <input type="text" defaultValue="Jason" ref="account"/>
                            </div>
                            <div className="row pass">
                                <label>密码</label>
                                <input type="text" ref="password"/>
                            </div>
                            <div className="row remember">
                                <input type="checkbox" defaultChecked/>
                                <span>记住密码</span>
                            </div>
                            <div className="row button">
                                <button onClick={this.auth}>登录</button>
                            </div>
                        </div>;
            }
        });
    </script>
  </body>
</html>

 
