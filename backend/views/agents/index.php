<?php

/* @var $this yii\web\View */

$this->title = '代理人';
?>
<div>
    
    <ul class="search-con clearfix">
        <li>
            <span>始发站</span>
            <input type="text" class="form-control" placeholder="" style="width:200px;" id="start_station">
        </li>
        <li>
            <span>&nbsp;</span>
            <button type="button" class="btn btn-primary" id="search">搜索</button>
        </li>
    </ul>

    <div class="grid">
        <div class="grid-toolbar">
            <div class="grid-btns clearfix">
                <div class="pull-right">
                    <button type="button" class="btn btn-primary grid-btn-sep" id="import_agents_btn">导入</button>
                    <a type="button" class="btn btn-primary" id="editAgent" href="/agents/edit?id">新增</a>
                </div>
            </div>

        </div>
        
        <div class="grid-content" id="agent_grid">
            <table class="table form">
                <thead>
                  <tr>
                    <th width="60" class="align-c">序号</th>
                    <th>始发站</th>
                    <th>简码</th>
                    <th>财务结算代码</th>
                    <th>代理人名称</th>
                    <th>经理</th>
                    <th>经理电话</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    
    <script type="text/template" id="agent_grid_template">
        <td class="align-c"><%- i %></td>
        <td><%- start_station %></td>
        <td><%- simple_code %></td>
        <td><%- financial_code %></td>
        <td><%- name %></td>
        <td><%- manager %></td>
        <td><%- manager_phone %></td>
        <td>
            <a class="edit" href="javascript:;" data-id="<%- id%>">修改</a>
            <a class="btn-del" href="javascript:;" data-id="<%- id%>">删除</a>
        </td>
    </script>
    <script type="text/javascript">
        seajs.use('/js/agents/agents-index.js');
    </script>
</div>
