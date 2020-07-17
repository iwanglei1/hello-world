import java.io.Serializable;

public class JavaTest1 implements Serializable {

    public static void main(String[] args) {
       /* System.out.println("Hello World");

        sss lis = new sss();
        lis.speak();*/
        sss lis = new sss();
        System.out.println(sss.class);

    }

}

class sss implements Serializable{
    String name = "Lawther Wang";
    int age = 23;
    void speak(){
        System.out.println("My name is "+name+" i am "+age);
    }
}