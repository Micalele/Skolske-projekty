package Sudoku;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;

public class Frame {

    private JFrame frame = new JFrame("Sudoku");
    private ImageIcon frameIcon = new ImageIcon("D:\\STU FEI\\FunStuff\\SudokuAI\\src\\Sudoku\\Icons\\sudokuIcon2.png");

    private Dimension textDimension = new Dimension(25, 25);
    private Dimension frameDimension = new Dimension(800, 850);

    private JPanel panel = new JPanel();
    private JPanel buttonPanel = new JPanel();

    private GridLayout gridLayout = new GridLayout(9, 9);

    private JButton solveButton = new JButton("SOLVE");
    private JButton loadButton = new JButton("Load Sudoku");

    private Font font = new Font("lol", 10, 60);

    private JTextField[][] textFieldsMatrix = new JTextField[9][9];

    public Frame() {
        solveButton.addActionListener(solveButtonAL);
        loadButton.addActionListener(loadButtonAL);
        buttonPanel.add(solveButton);
        buttonPanel.add(loadButton);
        frame.add(buttonPanel, BorderLayout.SOUTH);

        panel.setLayout(gridLayout);
        makeTextFields();
        frame.add(panel);

        frameStuff();
    }

    private ActionListener solveButtonAL = new ActionListener() {
        @Override
        public void actionPerformed(ActionEvent e) {
            setFramesColor();
            solveAI();
            printMatrix();
            //rowCheck(0,0);
            //columnCheck(0,0);
            //cubeCheck(0,0);
            //System.out.println("rowCheck = "+rowCheck(0,0)+"\ncolCheck = "+columnCheck(0,0)+"\ncubeCheck = "+cubeCheck(0,0));
        }
    };

    private ActionListener loadButtonAL = new ActionListener() {
        @Override
        public void actionPerformed(ActionEvent e) {
            clearTextFieldMatrix();
            setFramesColor();
            String sudoku = new String();
            File file = new File("D:\\STU FEI\\FunStuff\\SudokuAI\\src\\SudokuTxt\\TestSudoku1.txt");
            try {
                FileReader fileReader
                        = new FileReader(file);
                BufferedReader bufferedReader
                        = new BufferedReader(fileReader);
                String line;
                while ((line = bufferedReader.readLine()) != null) {
                    sudoku += line;
                }
                bufferedReader.close();
            } catch (java.io.FileNotFoundException ex) {
                System.out.println("File not found.\n");
            } catch (java.io.IOException ex) {
                System.out.println("Error reading file");
            }
            char[] chars = sudoku.toCharArray();
            int pc = 0;
            for (int pc1 = 0; pc1 < 9; pc1++) {
                for (int pc2 = 0; pc2 < 9; pc2++) {
                    if (chars[pc] != '0') {
                        textFieldsMatrix[pc1][pc2].setText("" + chars[pc]);
                        textFieldsMatrix[pc1][pc2].setEditable(false);
                    }
                    pc++;
                }
            }
            printMatrix();
        }
    };

    private void frameStuff() {
        frame.setIconImage(frameIcon.getImage());
        frame.setSize(frameDimension);
        frame.setDefaultCloseOperation(WindowConstants.EXIT_ON_CLOSE);
        frame.setVisible(true);
    }

    private void setFramesColor() {
        int pc = 0;
        for (int row = 0; row < 9; row += 3) {
            for (int column = 0; column < 9; column += 3) {
                if (pc == 0) {
                    for (int pc1 = 0; pc1 < 3; pc1++) {
                        for (int pc2 = 0; pc2 < 3; pc2++) {
                            textFieldsMatrix[row + pc1][column + pc2].setBackground(new Color(136, 235, 120));
                        }
                    }
                    pc = 1;
                } else {
                    for (int pc1 = 0; pc1 < 3; pc1++) {
                        for (int pc2 = 0; pc2 < 3; pc2++) {
                            textFieldsMatrix[row + pc1][column + pc2].setBackground(new Color(218, 235, 194));
                        }
                    }
                    pc = 0;
                }
            }
        }
    }

    private void clearTextFieldMatrix() {
        for (int pc1 = 0; pc1 < 9; pc1++) {
            for (int pc2 = 0; pc2 < 9; pc2++) {
                textFieldsMatrix[pc1][pc2].setText("");
            }
        }
    }

    private void makeTextFields() {
        for (int pc1 = 0; pc1 < 9; pc1++) {
            for (int pc2 = 0; pc2 < 9; pc2++) {
                JTextField textField = new JTextField();
                textField.setHorizontalAlignment(JTextField.CENTER);
                textField.setPreferredSize(textDimension);
                textField.setFont(font);
                textFieldsMatrix[pc1][pc2] = textField;
                textFieldsMatrix[pc1][pc2].setText("");
                panel.add(textField);
            }
        }
        setFramesColor();
    }

    private void printMatrix() {
        for (int pc1 = 0; pc1 < 9; pc1++) {
            for (int pc2 = 0; pc2 < 9; pc2++) {
                if(textFieldsMatrix[pc1][pc2].getText().equals("")) System.out.print(" ");
                System.out.print(textFieldsMatrix[pc1][pc2].getText() + " ");
            }
            System.out.println();
        }
    }

    private boolean isInteger(String s) {
        try {
            Integer.parseInt(s);
        } catch (NumberFormatException e) {
            return false;
        } catch (NullPointerException e) {
            return false;
        }
        return true;
    }

    private boolean rowCheck(int row, int column) {
        for (int pc = 0; pc < 9; pc++) {
            if (pc != column) {
                if (textFieldsMatrix[row][pc].getText().equals(textFieldsMatrix[row][column].getText()) && !textFieldsMatrix[row][column].getText().equals(new String())) {
                    textFieldsMatrix[row][column].setBackground(Color.red);
                    return false;
                }
            }
        }
        return true;
    }

    private boolean columnCheck(int row, int column) {
        for (int pc = 0; pc < 9; pc++) {
            if (pc != row) {
                if (textFieldsMatrix[pc][column].getText().equals(textFieldsMatrix[row][column].getText()) && !textFieldsMatrix[row][column].getText().equals(new String())) {
                    textFieldsMatrix[row][column].setBackground(Color.red);
                    return false;
                }
            }
        }
        return true;
    }

    private boolean cubeCheck(int row, int column) {
        int minRow = -1;
        int minCol = -1;
        if (row >= 0 && row <= 2) {
            minRow = 0;
            minCol = cubeCheckCols(column);
        } else if (row >= 3 && row <= 5) {
            minRow = 3;
            minCol = cubeCheckCols(column);
        } else if (row >= 6 && row <= 8) {
            minRow = 6;
            minCol = cubeCheckCols(column);
        }

        if (minCol != -1 && minRow != -1) {
            for (int r = minRow; r <= minRow + 2; r++) {
                for (int c = minCol; c <= minCol + 2; c++) {
                    if (r != row || c != column) {
                        //System.out.println("kok");
                        if (textFieldsMatrix[r][c].getText().equals(textFieldsMatrix[row][column].getText()) && !textFieldsMatrix[row][column].getText().equals(new String())) {
                            textFieldsMatrix[row][column].setBackground(Color.red);
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }

    private boolean check(int row, int column){
        if(rowCheck(row,column)&&columnCheck(row,column)&&cubeCheck(row,column)){
            return true;
        }
        else{
            return false;
        }
    }

    private int cubeCheckCols(int column) {
        if (column >= 0 && column <= 2) {
            return 0;
        } else if (column >= 3 && column <= 5) {
            return 3;
        } else/*(column >= 6 && column <= 8)*/ {
            return 6;
        }
    }

    private boolean solveAI() {
        for(int row = 0; row < 9; row++){
            for(int col = 0; col < 9; col++){
                if(textFieldsMatrix[row][col].getText().equals("")){
                    for(int number = 1; number < 10; number++){
                        textFieldsMatrix[row][col].setText(""+number);
                        if(check(row,col)){
                            if(solveAI()){
                                return true;
                            }
                            else{
                                textFieldsMatrix[row][col].setText("");
                            }
                        }
                    }
                    textFieldsMatrix[row][col].setText("");
                    return false;
                }
            }
        }
        setFramesColor();
        return true;
    }
}