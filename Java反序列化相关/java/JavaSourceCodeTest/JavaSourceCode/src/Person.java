import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.Serializable;

public class Person implements Serializable {

    private static final long serialVersionUID = 8428798474641047929L;

    private String name;

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    private void readObject(ObjectInputStream in) throws ClassNotFoundException, IOException, IOException {
        in.defaultReadObject();   //调用，否则不能经对象的值还原，尽管它仍然可以打开计算器
        Runtime.getRuntime().exec("calc");
    }

}
