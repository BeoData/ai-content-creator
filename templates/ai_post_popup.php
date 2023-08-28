<style>
    #ai_post_popup {
        padding: 20px;
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    #ai_post_popup h2 {
        margin-top: 0;
        margin-bottom: 20px;
        color: #333;
    }

    .ai-form-group {
        margin-bottom: 15px;
    }

    .ai-form-group label {
        display: block;
        margin-bottom: 5px;
        color: #555;
    }

    .ai-form-group input[type="text"] {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .ai-form-group input[type="submit"] {
        background-color: #0073aa;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .ai-form-group input[type="submit"]:hover {
        background-color: #0071a1;
    }
</style>

<div id="ai_post_popup" style="display:none;">
    <h2>Create AI Post</h2>
    <form action="" method="GET">
        <div class="ai-form-group">
            <label for="ai_post_title">Post Title:</label>
            <input type="text" id="ai_post_title" name="ai_post_title" required>
        </div>
        
        <div class="ai-form-group">
            <input type="hidden" name="create_ai_post" value="1">
            <input type="submit" value="Create AI Post">
        </div>
    </form>
</div>
