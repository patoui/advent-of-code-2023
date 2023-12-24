import 'dart:convert';
import 'dart:io';

void main() async {
  var input = File("example.txt");

  Stream lines = input
    .openRead()
    .transform(utf8.decoder)
    .transform(LineSplitter());

  List<int> times = [];
  List<int> distances = [];

  await for (var line in lines) {
    print(line);

    List<int> numbers = RegExp(r'\d+')
      .allMatches(line)
      .map((match) => int.parse(match.group(0)!))
      .toList();

    if (times.length == 0) {
      times = numbers;
    } else {
      distances = numbers;
    }
  }
  
  int distance = 0;
  int speed = 0;

  for (int i = 0; i < times.length; i++) {
    int raceTime = times[i];
    int raceDistance = distances[i];

    print('$raceTime $raceDistance');

    // solve me!
  }
}
