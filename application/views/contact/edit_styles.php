<style>
    .newComponentGroup {
        margin-top: 20px;
        border-top: 1px solid #e5e5e5;
        padding-top: 20px;
    }
    #txtNotes {
        min-height: 266px;        
    }
    #picture { 
        display: inline;
        position: relative; 
    }
    #picture a {
        color: black;
        position: absolute;
        text-decoration: underline;
        height: 20px;
        top: 50%;
        margin-top: -10px;
        left: 3px;
        right: 3px;
        text-align: center;
        visibility: hidden;
        background-color: rgba(255, 255, 255, 0.75);
    }
    #picture:hover img {
        border-color: rgba(130, 182, 222, 0.870588);
    }
    #picture:hover a {
        visibility: visible;
    }
</style>