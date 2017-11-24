# Unit Testing explained with PHPUnit and Mockery in Laravel 5.4

Through my work experience as a PHP developer, I often encountered projects which don't write/execute unit testing. Actually, when I start my career, I didn't even know how to write unit testing. Writing code Without unit testing means that you have to make sure a method/class you implemented works correctly manually. This is really time-consuming task and I did manual testing so many time. 

The main reason why I'm really interested in unit testing is that when I modify exisitng method/class, there is no way to make sure the change works properly except for manually checking using browsers or debugging tools. Also, even if you verified the change, it might cause regression errors somewhere on the project. This fact intimidated me; therefore, I felt it's worth to study. (hidden agenda is to get a job) 

In order to acquire unit testing skill, I red this textbook, "Practical Unit Testing with JUnit and Mockito". Then, I applied unit testing  to my own project.

## Example

As a simple example, I created a method in service class as following: 

```
public function findDictionaryWithItsWords(int $id)
{
    // find dictionary with eager loading by its id
    $dic = $this->dicRepo->findDictionaryWithItsWords($id);
    // create View Model for show page
    $viewModel = Dic::createWith($dic);

    return $viewModel;
}
```

To write unit testing, I usually draw diagram to identify components such as SUT, DOCs, and Dummy like below: 

![alt text](./UnitTest_Diagram.png?raw=true)

Here is unit testing for this method: 

```
    /** @test */
    public function it_return_dictionary_view_model_object()
    {
      // 1. arrange
      //  prepare dummy
      $dic_dummy_id = 1;
      $dic_dummy_model = new \App\Model\Dictionary;
      // stub 1 :  DictionaryRepoInterface
      $this->dicRepo_mock
           ->shouldReceive('findDictionaryWithItsWords')
           ->with($dic_dummy_id)
           ->once()
           ->andReturn($dic_dummy_model);
      // stub 2 : Dic class
      $this->Dic_mock
           ->shouldReceive('createWith')
           ->with($dic_dummy_model)
           ->once()
           ->andReturn('view_model');
      // 2. act
      $result = $this->sut->findDictionaryWithItsWords($dic_dummy_id);
      // 3. assert
      $this->assertEquals('view_model', $result);
    }
```
# Source code
Related source code is [here](./DictionaryServiceTest.php).

