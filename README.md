# Unit Testing explained with PHPUnit and Mockery in Laravel 5.4

Through my work experience as a PHP developer, I oftenly encountered projects which don't write/execute unit testing. Actually, when I start my career, I didn't even know how to write unit testing. Writing code Without unit testing means that you have to make sure a method/class you implemented works correctly manually. This is really time-consuming task and I did manual testing so many time. 

In order to acquire unit testing skill, I red this textbook, "Practical Unit Testing with JUnit and Mockito". then, I applied unit testing  to my own project.

## Example

As a simple example, I created a method in service class as following: 

```
public function findDictionaryWithItsWords(int $id)
  {
    // find dictionary by its id
    $dic = $this->dicRepo->find($id);
    // retrieve words associated with the dictionary
    $words = $dic->words;
    // create View Model for show page
    $viewModel = Dic::createWith($dic, $words);

    return $viewModel;
  }
```
