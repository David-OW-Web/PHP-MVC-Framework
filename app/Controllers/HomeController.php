<?php

require '../app/Models/Post.php';

class HomeController extends Controller
{
    public function Index() {
        $data = [
            "title" => "Home",
            "text" => "This is the home page"
        ];
        $article = new Post();
        print_r($article->Select()->Get());
        $this->View($data, 1);
    }

    public function CreatePost() {
        $post = new Post();
        $_POST['title'] = "Not empty";
        if(!empty($_POST['title'])) {
            $post->post_id = null;
            $post->title = "Title of post";
            $post->body = "Body of post";
            $post->created_at = date("Y-m-d H:i:s");
            $post->updated_at = null;
            $post->save();
            Helper::Redirect("Home", "Index");
        }
    }

    public function UpdatePost() {
        $post = new Post();
        $_POST['title'] = "Not empty";
        if(!empty($_POST['title'])) {
            $post->post_id = 27;
            $post->title = "Title of post#1";
            $post->body = "Body of post#1";
            $post->Update(["title" => $post->title, "body" => $post->body])->Where(["post_id" => $post->post_id]);
            Helper::Redirect("Home", "Index");
        }
    }

    public function Details() {
        $post = new Post();
        $post->Select()->Get();
        $post->Select()->Take(5);
        $post->Select()->Where(["post_id" => $post->post_id])->Get();
        $post->Select()->Where(["post_id" => $post->post_id])->Count();
        $post->Select()->OrderBy(["ASC" => "created_at"])->Get();
        $post->Join(["x" => "category.title"], ["category.fk_category_id" => "post.fk_category_id"])->Get();
    }

    public function DeletePost() {
        $post = new Post();
        $post->post_id = 27;
        $post->Delete()->Where(["post_id" => $post->post_id]);
    }
}